#!/bin/bash
# Substitui a porta padrão do Apache pela porta do Railway
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Inicia o Apache em foreground
apache2-foreground
