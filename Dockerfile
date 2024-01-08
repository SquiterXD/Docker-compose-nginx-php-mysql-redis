FROM php:7.3.6-fpm-alpine3.9

RUN apk --no-cache add openssl bash mysql-client nodejs npm
RUN docker-php-ext-install pdo_mysql bcmath

WORKDIR /var/www

RUN rm -rf /var/www/html
RUN ln -s public html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
## RUN composer create-project --prefer-dist laravel/laravel src

EXPOSE 9000

ENTRYPOINT [ "php-fpm" ]
