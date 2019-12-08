FROM xachman/cakephp3

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
apt-get install -y nodejs && \
sed -i 's/DocumentRoot \/var\/www/DocumentRoot \/var\/www\/webroot/g' /etc/apache2/sites-available/000-default.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
php composer-setup.php && \
php -r "unlink('composer-setup.php');" && \
mv composer.phar /usr/local/bin/composer

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