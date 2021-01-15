FROM php:7.4.13-fpm-alpine

ARG TIMEZONE
ARG DBUSER
ARG DBPASS
ARG DBNAME

ENV DB_USER=${DBUSER}
ENV DB_PASS=${DBPASS}
ENV DB_NAME=${DBNAME}

RUN echo "date.timezone=${TIMEZONE}" > $PHP_INI_DIR/conf.d/date_timezone.ini

RUN apk --update add --virtual build-dependencies build-base openssl-dev autoconf

RUN docker-php-ext-install pdo_mysql

RUN apk del build-dependencies build-base openssl-dev autoconf && rm -rf /var/cache/apk/*

COPY ./api .

EXPOSE 9000

CMD [ "php-fpm" ]