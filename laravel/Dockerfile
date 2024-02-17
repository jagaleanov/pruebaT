# Imagen base con PHP 8.3.2 y Apache
FROM php:8.3.2-apache

# Instalar extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar el virtual host a Apache
COPY ./prueba.test.conf /etc/apache2/sites-available/prueba.test.conf

# Habilitar el sitio de prueba.test
RUN a2ensite prueba.test.conf

# Deshabilitar el sitio predeterminado de Apache
RUN a2dissite 000-default.conf

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto Laravel al contenedor
COPY . /var/www/html

# Dar permiso al directorio de Laravel
# Ajustar los permisos correctamente para storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/storage -type d -exec chmod 775 {} \; \
    && find /var/www/html/bootstrap/cache -type d -exec chmod 775 {} \; \
    && find /var/www/html/storage -type f -exec chmod 664 {} \; \
    && find /var/www/html/bootstrap/cache -type f -exec chmod 664 {} \;
