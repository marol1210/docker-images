FROM php:8.1-alpine

ENV APK_REPOSITORY_URL=mirrors.cernet.edu.cn
ENV APK_REPOSITORY_ORIGIN=dl-cdn.alpinelinux.org
ENV PROJECT_DIR ${PROJECT_DIR:-/var/www/html/laravel}

WORKDIR /var/www/html

# Latest release
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN sed "s/${APK_REPOSITORY_ORIGIN}/${APK_REPOSITORY_URL}/" -i  /etc/apk/repositories \
    && apk update \
    && docker-php-exe-configure pdo_mysql ; docker-php-ext-install pdo_mysql \
    && composer config -g repos.packagist composer https://mirrors.tencent.com/composer/ 
   
RUN adduser -D -h /home/laravel -s /bin/ash laravel www-data 
USER laravel:www-data

RUN composer create-project laravel/laravel:^8.0 laravel \
    && composer -d ${PROJECT_DIR} require laravel/fortify:^1.0 laravel/octane:~1.5.0 laravel/sanctum -W

COPY ./start.sh /var/www
CMD [ "/var/www/start.sh" ]