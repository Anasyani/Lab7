FROM php:8.2-fpm

RUN apt-get update && apt-get install -y git unzip curl librdkafka-dev \
    && docker-php-ext-install pdo pdo_mysql

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# vendor ставим в /var/www/vendor, чтобы его не перекрывал том ./www
WORKDIR /var/www
COPY composer.json /var/www/
RUN composer install

WORKDIR /var/www/html
COPY ./www /var/www/html

CMD ["php-fpm"]
