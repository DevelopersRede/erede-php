FROM php:8.1-cli
LABEL maintainer="neto.joaobatista@gmail.com"

RUN apt -y update && apt -y install libzip-dev
RUN docker-php-ext-install zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /bin/composer

ADD . /src/erede-php
WORKDIR /src/erede-php

RUN composer install

RUN echo "./vendor/bin/phpcs --ignore=vendor --standard=PSR12 src test\n">tests
RUN echo "./vendor/bin/phpstan\n" >>tests
RUN echo "./vendor/bin/phpcpd src tests\n" >>tests
RUN echo "./vendor/bin/phpunit --testdox --colors='always' test" >>tests

CMD sh tests