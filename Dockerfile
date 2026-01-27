# Dockerfile para PHP CLI (servidor built-in)
FROM php:8.2-cli

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Directorio de trabajo
WORKDIR /app

# Copiar proyecto
COPY . .

# Crear usuario no-root para seguridad
RUN useradd -m -u 1000 phpuser \
    && chown -R phpuser:phpuser /app

# Cambiar a usuario no-root
USER phpuser

# Puerto
EXPOSE 8000

# Comando con servidor PHP integrado
CMD ["php", "-S", "0.0.0.0:8000"]