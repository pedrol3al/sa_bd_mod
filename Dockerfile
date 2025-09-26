# Usa imagem oficial PHP com Apache
FROM php:8.1-apache

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos do projeto para a pasta do Apache
COPY . /var/www/html/

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Permite acesso ao Apache
RUN echo '<Directory /var/www/html>\n    Require all granted\n</Directory>' \
    >> /etc/apache2/apache2.conf

# Expõe porta 80 (Railway vai mapear automaticamente)
EXPOSE 80

# Copia o entrypoint
COPY docker-entrypoint.sh /usr/local/bin/

# ENTRYPOINT adaptado para Windows
ENTRYPOINT ["bash", "/usr/local/bin/docker-entrypoint.sh"]
