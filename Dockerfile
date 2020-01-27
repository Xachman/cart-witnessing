FROM xachman/cakephp3

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
apt-get install -y nodejs wget

RUN apt install wget && wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet && \
mv composer.phar /usr/local/bin/composer && \
chmod +x  /usr/local/bin/composer 

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