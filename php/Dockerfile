FROM php:8.2-fpm

ARG USER_DIR=/home/symfony
ARG PROJECT_DIR=/home/symfony/docker

RUN apt-get update && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN groupadd -g 1000 symfony
RUN useradd -d $USER_DIR -s /bin/bash -u 1000 -g 1000 symfony

RUN mkdir -p $USER_DIR
RUN mkdir -p $PROJECT_DIR

RUN chown -R symfony:symfony $USER_DIR
RUN chown -R symfony:symfony $PROJECT_DIR
RUN chown -R symfony:symfony /var/www/
RUN chown -R symfony:symfony /usr/local/share/ca-certificates
RUN chown -R symfony:symfony /etc/ssl/certs

WORKDIR $PROJECT_DIR

USER symfony