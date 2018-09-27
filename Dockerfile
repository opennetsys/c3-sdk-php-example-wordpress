FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y
RUN apt-get install software-properties-common -y
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update -y

# nginx-extras if for more_set_headers plugin
RUN apt-get install curl wget git vim mysql-server php-dev php7.2 php7.2-dev php-ssh2 php7.2-gd imagemagick php7.2-imagick php-mbstring php7.2-zip nginx nginx-extras php7.2-fpm php7.2-mysql php7.2-mysql php7.2-curl postfix --fix-missing -y

RUN phpenmod mbstring

RUN wget http://wordpress.org/latest.tar.gz && tar xzvf latest.tar.gz

RUN mkdir -p /var/www/html && cp -r wordpress/. /var/www/html/ && mkdir -p /var/www/html/wp-content/uploads

RUN cp /etc/nginx/sites-available/default /etc/nginx/sites-available/wordpress

COPY rootfs /
COPY app /app

RUN mv /nginx/nginx.conf /etc/nginx/sites-available/wordpress
RUN ln -s /etc/nginx/sites-available/wordpress /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp

# https://stackoverflow.com/questions/9192027/invalid-default-value-for-create-date-timestamp-field
RUN echo "sql_mode = ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" >> /etc/mysql/mysql.conf.d/mysqld.cnf

RUN mv -n /state.json /tmp/state.json

CMD /entrypoint.sh
