#!/usr/bin/env bash

##################################################
# Third Party Repositories
##################################################

# To use add-apt-repository you have to install it first
apt-get install -y python-software-properties

apt-get update

##################################################
# Apache
##################################################

# install apache
echo Installing apache...
apt-get install -y apache2

# setup hosts file
echo Setup vhosts...
VHOST=$(cat <<EOF
<VirtualHost *:80>
    ServerName router.local
    DocumentRoot "/vagrant"
    <Directory "/vagrant">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/vagrant.conf

ln -s /etc/apache2/sites-available/vagrant.conf /etc/apache2/sites-enabled/vagrant.conf

# enable apache mods...
echo Enable apache mods...
a2enmod rewrite

# restart webserver
echo Restarting apache...
service apache2 restart

##################################################
# PHP
##################################################
echo Installing php...

# Add the php 5.6 repository
add-apt-repository -y ppa:ondrej/php5-5.6
apt-get update

# install php 5.6, apache2 mod, mysqli, gd, imagemagick...
apt-get install -y php5 php5-mcrypt php5-curl libapache2-mod-php5 php5-mysqlnd php5-gd php5-imagick

# restart webserver
echo Restarting apache...
service apache2 restart
