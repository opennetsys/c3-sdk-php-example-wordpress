#!/bin/bash

usermod -d /var/lib/mysql/ mysql

# touching file is required
# https://github.com/moby/moby/issues/34390
find /var/lib/mysql -type f -exec touch {} \; && service mysql start

service nginx start
service php7.2-fpm start

mysql -u root < /sql/bootstrap.sql

wp core config --dbname=wordpress --dbuser=wpuser --dbpass= --dbhost=localhost --dbprefix=wp_ --allow-root --path=/var/www/html

wp core install --url="http://localhost:8080" --title="Blog Title" --admin_user="admin" --admin_password="password" --admin_email="example@example.com" --allow-root --path=/var/www/html

wp plugin install /plugins/basic-auth.zip --activate --allow-root --path=/var/www/html

php /app/App.php
