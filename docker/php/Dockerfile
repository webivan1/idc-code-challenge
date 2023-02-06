FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_pgsql pdo_mysql gd zip

WORKDIR /app
COPY . /app

EXPOSE 9000
CMD ["php-fpm"]
