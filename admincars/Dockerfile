FROM php:7.4-fpm-alpine

RUN apk --update add --virtual build-dependencies build-base openssl-dev autoconf \
  && pecl install mongodb \
  && pecl install xdebug \
  && docker-php-ext-enable mongodb xdebug \
  && apk del build-dependencies build-base openssl-dev autoconf \
  && rm -rf /var/cache/apk/*

  RUN echo 'zend_extension="/usr/local/lib/php/extensions/no-debug-non-zts-20190902/xdebug.so"' >> /usr/local/etc/php/php.ini
  RUN echo 'xdebug.remote_port=9002' >> /usr/local/etc/php/php.ini
  RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
  RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini
  RUN echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/php.ini
