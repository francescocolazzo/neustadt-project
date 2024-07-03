FROM php:8.2-fpm-alpine

WORKDIR /var/www/app

RUN apk update && apk add \
    autoconf \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    make \
    gcc \
    g++ \
    unzip \
    supervisor

RUN docker-php-ext-install pdo pdo_mysql pcntl\
    && apk --no-cache add nodejs npm 

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY config/supervisor.conf /etc/supervisor/conf.d/supervisord.conf
 
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
 