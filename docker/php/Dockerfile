FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
        zlib1g-dev libicu-dev g++ \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install tokenizer \
        mbstring \
        opcache \
        exif \
        pdo \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /var/www/html

COPY ./php.ini-development /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

EXPOSE 9000

WORKDIR /var/www
