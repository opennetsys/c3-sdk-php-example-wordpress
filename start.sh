#!/bin/bash

# touching file is required
# https://github.com/moby/moby/issues/34390
find /var/lib/mysql -type f -exec touch {} \; && service mysql start

service nginx start
service php7.2-fpm start

php /app/App.php
