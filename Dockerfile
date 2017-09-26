FROM drupal:fpm
COPY . /var/www/html/
# must need volume
VOLUME /var/www/html