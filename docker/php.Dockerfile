# ----------------------
# The FPM base container
# ----------------------
FROM php:7.4.11-fpm as dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /app

# ----------------------
# Composer install step
# ----------------------
FROM composer:2.7.2 as build

WORKDIR /app

COPY composer.* ./
COPY database/ database/
COPY nova/ nova/
COPY nova-components/ nova-components/

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# ----------------------
# npm install step
# ----------------------
FROM node:10.24.1-alpine as node

WORKDIR /app

COPY *.json *.mix.js *.config.js /app/
COPY resources /app/resources

#todo: temp until mix is fixed
#RUN mkdir -p /app/public \
#    && npm install && npm run production


WORKDIR /app/nova

COPY *.json *.mix.js *.config.js /app/nova/
COPY resources /app/nova/resources

#todo: temp until mix is fixed
#RUN mkdir -p /app/nova/public \
#    && npm install && npm run production

# ----------------------
# The FPM production container
# ----------------------
FROM dev

COPY ./docker/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY . /app
COPY --from=build /app/vendor/ /app/vendor/
#COPY --from=node /app/public/ /app/public/
#COPY --from=node /app/mix-manifest.json /app/public/mix-manifest.json

#COPY --from=node /app/nova/public/ /app/nova/public/
#COPY --from=node /app/nova/mix-manifest.json /app/nova/public/mix-manifest.json

RUN chmod -R 777 /app/storage

RUN php artisan cache:clear
