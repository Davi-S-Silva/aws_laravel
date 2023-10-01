#!/bin/bash
export WEB_DIR="/var/www/html"

cd $WEB_DIR

sudo chmod g+w -R storage

sudo cp .env.example .env

sudo apt install php8.0
sudo apt install php-curl php-cli php-mbstring git unzip php8.0-mysql php8.0-dom php8.0-xml php8.0-xmlwriter phpunit php-mbstring php-xml

service httpd restart

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

sudo -u $WEB_USER composer install --no-dev --no-progress --prefer-dist