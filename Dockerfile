FROM ghcr.io/joy2fun/docker-php:master

COPY docker/php.ini /usr/local/etc/php/conf.d/zzz.ini
COPY docker/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY --chown=www-data:www-data . .

RUN curl -o /usr/local/bin/composer https://getcomposer.org/download/latest-stable/composer.phar \
    && chmod +x /usr/local/bin/composer; \
    composer install -n --ignore-platform-reqs --no-dev --no-progress --optimize-autoloader \
    && composer clear-cache \
    && mv .env.example .env