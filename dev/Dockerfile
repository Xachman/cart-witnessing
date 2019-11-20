FROM xachman/cakephp3

RUN apt-get install -y git

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sL https://deb.nodesource.com/setup_4.x | bash - && \
apt-get install -y nodejs 

COPY . /var/www/
WORKDIR /var/www
RUN chown www-data:www-data -R ./
RUN chmod 775 -R ./
USER www-data
ARG COMPOSER_INSTALL
ARG NPM_INSTALL
RUN composer install ${COMPOSER_INSTALL}
RUN npm install ${NPM_INSTALL}


USER root
