FROM php:8.1.13-cli

RUN apt-get update; apt-get install -y apt-utils zip vim telnet git iputils-ping net-tools iproute2 netcat

#extention installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions gd opcache zip pdo_mysql mysqli bcmath intl exif xdebug @composer

RUN echo '\
 xdebug.mode=develop,debug \n\
 xdebug.client_port=9001 \n\
 xdebug.var_display_max_children=-1 \n\
 xdebug.var_display_max_data=-1 \n\
 xdebug.var_display_max_depth=-1 \n\
 memory_limit=4G \n\
' >> $(php --ini | grep xdebug | awk 'BEGIN {FS="," }; {print $1}')

WORKDIR /var/www
