FROM webdevops/php-nginx:7.4-alpine
# Install Laravel framework system requirements (https://laravel.com/docs/8.x/deployment#optimizing-configuration-loading)
RUN apk add oniguruma-dev postgresql-dev libxml2-dev supervisor
RUN docker-php-ext-install \
        bcmath \
        ctype \
        fileinfo \
        json \
        mbstring \
        pdo_pgsql \
        tokenizer \
        xml
# Copy Composer binary from the Composer official Docker image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV local
WORKDIR /app
COPY . .
RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN mkdir -p "/etc/supervisor/logs"
COPY docker/supervisord.conf /etc/supervisor/supervisord.conf


# Optimizing Configuration loading
RUN php artisan config:cache
# Optimizing View loading
RUN php artisan view:cache

RUN php artisan telescope:install
RUN php artisan storage:link

RUN chown -R application:application .

CMD ["php", "/app/discordapp/index.php"]
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
