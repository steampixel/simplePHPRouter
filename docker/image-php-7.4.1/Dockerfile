FROM php:7.4.1-apache

RUN a2enmod rewrite

# Install composer
# https://www.hostinger.com/tutorials/how-to-install-composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
