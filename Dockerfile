# Dockerfile
FROM php:8.1-apache

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar los archivos del proyecto
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html

# Puerto expuesto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]