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

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod 777 wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp

RUN wget https://github.com/fullstorydev/grpcurl/releases/download/v1.1.0/grpcurl_1.1.0_linux_x86_64.tar.gz && \
  tar -xvzf grpcurl_1.1.0_linux_x86_64.tar.gz && \
  chmod 777 grpcurl && \
  mv grpcurl /usr/local/bin/grpcurl

RUN wget https://github.com/opennetsys/c3-go/releases/download/v0.0.3/c3-go-linux-amd64 && chmod 777 c3-go-linux-amd64 && mv c3-go-linux-amd64 /usr/local/bin/c3-go

# https://stackoverflow.com/questions/9192027/invalid-default-value-for-create-date-timestamp-field
RUN echo "sql_mode = ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" >> /etc/mysql/mysql.conf.d/mysqld.cnf

RUN mv -n /state.json /tmp/state.json
RUN mv /mysql/mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf

RUN mkdir /var/www/.c3/
RUN mv /c3/config.toml /var/www/.c3/config.toml

CMD /entrypoint.sh
