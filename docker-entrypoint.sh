#!/bin/bash
# Configura Apache para usar a porta do Railway
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Permite acesso a raiz e subpastas
echo '<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>' >> /etc/apache2/apache2.conf

# Inicia Apache em foreground
apache2-foreground
