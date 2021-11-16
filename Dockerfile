FROM php:7.3-apache

RUN apt-get -yqq update
RUN apt-get -yqq install exiftool \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libpng-dev \
    libzip-dev


RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-install zip

#RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install gd

RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/001-php.ini /usr/local/etc/php/conf.d/001-php.ini
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD ["apache2-foreground"]