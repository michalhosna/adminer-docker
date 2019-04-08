FROM alpine:3.8

RUN	addgroup -S adminer && \
    adduser -S -G adminer adminer && \
    mkdir -p /var/adminer && \
    chown -R adminer:adminer /var/adminer

RUN apk add --no-cache \
    curl \
    php7 \
    php7-opcache \
    php7-pdo \
    php7-pdo_mysql \
    php7-pdo_odbc \
    php7-pdo_pgsql \
    php7-pdo_sqlite \
    php7-session

WORKDIR /var/adminer

ARG ADMINER_VERSION=4.7.0
ARG ADMINER_FLAVOUR="-en"
ARG ADMINER_CHECKSUM="d2884278a3f331673c9fe58d3456db875a48270fd7b7ba37492d132b074d0eaa"

RUN curl -L https://github.com/vrana/adminer/releases/download/v${ADMINER_VERSION}/adminer-${ADMINER_VERSION}${ADMINER_FLAVOUR}.php -o adminer.php && \
    echo "${ADMINER_CHECKSUM}  adminer.php"|sha256sum -c -

COPY index.php /var/adminer/index.php
COPY php.ini /etc/php7/conf.d/99_docker.ini

EXPOSE 8080

USER adminer
CMD [ "php", "-S", "[::]:8080", "-t", "/var/adminer" ]

