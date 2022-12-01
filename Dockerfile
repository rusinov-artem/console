FROM php:8.1.13-cli

RUN apt-get update; apt-get install -y apt-utils zip  git

#extention installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions @composer

WORKDIR /var/www
