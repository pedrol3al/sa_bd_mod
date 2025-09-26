# Usa imagem oficial PHP com Apache
FROM php:8.1-apache

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia arquivos do projeto para o Apache
COPY . /var/www/html/

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expõe porta 80 (Railway mapeia automaticamente)
EXPOSE 80

# Copia entrypoint
COPY docker-entrypoint.sh /usr/local/bin/

# ENTRYPOINT adaptado para Windows
ENTRYPOINT ["bash", "/usr/local/bin/docker-entrypoint.sh"]
