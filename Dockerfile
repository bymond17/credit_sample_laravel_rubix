FROM php:8.2

RUN apt-get update \
    && apt-get install -y zip unzip git \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

WORKDIR /var/www/html

# Laravel 프로젝트 자동 생성 (composer.json이 없을 때만)
RUN [ ! -f composer.json ] && composer create-project laravel/laravel . || true

# 의존성 설치
RUN composer install

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]