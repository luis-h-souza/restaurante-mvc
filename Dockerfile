# Usar imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite para URLs amigáveis
RUN a2enmod rewrite

# Configurar Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação
COPY . /var/www/html/

# Definir permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expor porta 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
