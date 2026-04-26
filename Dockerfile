# Dockerfile con Apache
FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Directorio de trabajo (Apache sirve desde /var/www/html)
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Crear usuario no-root para seguridad
RUN useradd -m -u 1000 phpuser \
    && chown -R phpuser:phpuser /var/www/html

# Puerto
EXPOSE 80
