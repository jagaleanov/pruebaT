FROM php:8.3.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    mariadb-client \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permitir ejecución de plugins como superusuario
ENV COMPOSER_ALLOW_SUPERUSER=1

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar el código fuente de Laravel al contenedor
COPY . /var/www/html

# Dar permiso al directorio de Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Instalar dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

# Exponer el puerto 9000
EXPOSE 9000
