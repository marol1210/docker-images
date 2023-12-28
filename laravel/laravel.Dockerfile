FROM php:8.1-alpine

ENV APK_REPOSITORY_URL=mirrors.cernet.edu.cn
ENV APK_REPOSITORY_ORIGIN=dl-cdn.alpinelinux.org
ENV PROJECT_DIR ${PROJECT_DIR:-/var/www/html/laravel}

WORKDIR /var/www/html

# Composer latest release
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN sed "s/${APK_REPOSITORY_ORIGIN}/${APK_REPOSITORY_URL}/" -i  /etc/apk/repositories \
    && apk update \
    && docker-php-ext-configure pdo_mysql ; docker-php-ext-install pdo_mysql
    
   
RUN adduser -D -h /home/laravel -s /bin/ash laravel www-data 
USER laravel:www-data


RUN composer config -g repositories.packagist composer https://packagist.pages.dev \
    && composer create-project laravel/laravel:^10.0 laravel \
    && composer -d ${PROJECT_DIR} require --prefer-stable laravel/fortify laravel/octane laravel/sanctum -W

COPY ./start.sh /
CMD [ "/start.sh" ]