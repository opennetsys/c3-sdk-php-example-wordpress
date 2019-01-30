#!/bin/bash

WP_PORT=8000

# TODO: debug why wordpress php is not reading env vars
echo "$IMAGE_ID" > /image_id

usermod -d /var/lib/mysql/ mysql

# this is a temporary fix
(cd /var/www/.c3 && c3-go generate key -o priv.pem)

#mv /state.json /tmp/state.json

# touching file is required
# https://github.com/moby/moby/issues/34390
find /var/lib/mysql -type f -exec touch {} \; && service mysql start

service nginx start
service php7.2-fpm start

mysql -u root < /sql/bootstrap.sql

wp core config --dbname=wordpress --dbuser=wpuser --dbpass= --dbhost='0.0.0.0' --dbprefix=wp_ --allow-root --path=/var/www/html

wp core install --url="http://localhost:$WP_PORT" --title="Blog Title" --admin_user="admin" --admin_password="password" --admin_email="example@example.com" --allow-root --path=/var/www/html

wp plugin install /plugins/basic-auth.zip --activate --allow-root --path=/var/www/html
wp plugin install /plugins/c3/c3.zip --activate --allow-root --path=/var/www/html

mysql wordpress -e 'TRUNCATE TABLE wp_posts;'
mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'pass' WITH GRANT OPTION;GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '' WITH GRANT OPTION;"

php /app/App.php
