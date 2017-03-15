FROM php:7.1-fpm

RUN apt-get update && \
  DEBIAN_FRONTEND=noninteractive apt-get install -y \
    php-pear

# PHP Extensions
RUN pecl install redis \
  &&  rm -rf /tmp/pear \
  && docker-php-ext-enable redis