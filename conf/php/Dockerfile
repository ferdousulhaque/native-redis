FROM php:latest

RUN pecl install redis && docker-php-ext-enable redis

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
