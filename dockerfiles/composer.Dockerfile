COPY --from=composer:2.2.6 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/shop

ENTRYPOINT ["composer"]
