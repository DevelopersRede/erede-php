FROM php:7.2-cli
LABEL maintainer="neto.joaobatista@gmail.com"

RUN apt -y update && apt -y install zlib1g-dev zip
RUN docker-php-ext-install zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /bin/composer

ADD . /src/erede-php
WORKDIR /src/erede-php

RUN composer install

RUN echo "./vendor/bin/phpunit --testdox --colors='always' test" >tests

CMD sh tests