FROM php:7.4-fpm

# Instala las extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zlib1g-dev \
    libzip-dev \
    zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cambia al directorio de la aplicación Laravel
WORKDIR /var/www/html

# Copia el código de Laravel al contenedor
COPY . .

# Instala las dependencias de Laravel
RUN composer update
RUN composer install

# Ejecuta Laravel con `php artisan serve`
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]