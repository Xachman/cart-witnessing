FROM xachman/cakephp3

RUN curl -sL https://deb.nodesource.com/setup_4.x | bash - && \
apt-get install -y nodejs && \
sed -i 's/DocumentRoot \/var\/www\/webroot/DocumentRoot \/var\/www/g' /etc/apache2/sites-available/000-default.conf

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