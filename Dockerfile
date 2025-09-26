# Usa imagem oficial PHP com Apache
FROM php:8.1-apache

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos do projeto para a pasta do Apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# Expõe porta 80 (Railway vai mapear automaticamente a porta real)
EXPOSE 80

# Copia o entrypoint
COPY docker-entrypoint.sh /usr/local/bin/

# ENTRYPOINT adaptado para Windows (executa via bash)
ENTRYPOINT ["bash", "/usr/local/bin/docker-entrypoint.sh"]
