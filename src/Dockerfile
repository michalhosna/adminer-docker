FROM alpine:3.13

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

ARG ADMINER_VERSION=4.8.1
ARG ADMINER_FLAVOUR="-en"
ARG ADMINER_CHECKSUM="4ec36be619bb571e2b5a5d4051bfe06f3fcadb3004969b993f2535f6ce28116b"

RUN curl -L https://github.com/vrana/adminer/releases/download/v${ADMINER_VERSION}/adminer-${ADMINER_VERSION}${ADMINER_FLAVOUR}.php -o adminer.php && \
    echo "${ADMINER_CHECKSUM}  adminer.php"|sha256sum -c -

COPY index.php /var/adminer/index.php
COPY php.ini /etc/php7/conf.d/99_docker.ini

EXPOSE 8080

USER adminer
CMD [ "php", "-S", "[::]:8080", "-t", "/var/adminer" ]

