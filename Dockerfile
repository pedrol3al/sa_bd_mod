
# Usa imagem oficial PHP com Apache
FROM php:8.1-apache

# Instala extensões necessárias (MySQL, PDO)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos do projeto para a pasta do Apache
COPY . /var/www/html/

# Dá permissão para a pasta
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80 (web)
EXPOSE 80