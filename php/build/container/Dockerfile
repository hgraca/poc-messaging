FROM php:8.1-cli

# OS setup
RUN export DEBIAN_FRONTEND=noninteractive \
    && apt-get update \
    && apt-get install -y \
        gnupg \
        git \
        zlib1g-dev \
        libzip-dev \
        libmemcached-dev \
        libfreetype6 \
        libfontconfig1 \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        poppler-utils \
        unzip \
        jq \
        wget \
        libxml2-dev \
        librdkafka-dev \
    # Cleanup image
    && apt-get -yqq autoremove \
    && apt-get -yqq clean \
    && rm -rf /var/lib/apt/lists/* /var/cache/* /tmp/* /var/tmp/*

# Install needed php extensions, configure and & enable them
RUN pecl install -o -f xdebug redis rdkafka-5.0.2 protobuf-3.19.3 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo_mysql zip gd mysqli gettext exif bcmath intl calendar soap pcntl posix \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl --location --silent --show-error --output /usr/local/bin/local-php-security-checker https://github.com/fabpot/local-php-security-checker/releases/download/v1.0.0/local-php-security-checker_1.0.0_linux_amd64 \
    && chmod +x /usr/local/bin/local-php-security-checker

COPY opcache.ini $PHP_INI_DIR/conf.d/
COPY rdkafka.ini $PHP_INI_DIR/conf.d/
COPY php.ini $PHP_INI_DIR
RUN chown www-data:www-data $PHP_INI_DIR/php.ini

# Override base entrypoint file, to do some extra things on startup
COPY docker-php-entrypoint /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-php-entrypoint

WORKDIR /var/www
