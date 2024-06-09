FROM node:16 AS node
FROM php:8.2-fpm
WORKDIR "/app"

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils  procps

# Update packages & Install Git and Supervisor
RUN apt-get update -y && \
    apt-get install -yq git supervisor libzip-dev cron nano unzip zip zlib1g-dev libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev libonig-dev mariadb-server libmagickwand-dev

RUN pecl install redis
RUN pecl install imagick

ENV PHP_MEMORY_LIMIT=1G

# Install GD extension
RUN docker-php-ext-enable redis
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j "$(nproc)" gd
RUN docker-php-ext-install mbstring exif pcntl bcmath zip
RUN docker-php-ext-enable imagick

# Install Swoole extension
RUN pecl install swoole
RUN docker-php-ext-enable swoole

# MySQL Support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy crontab file to the cron.d directory
COPY crontab /etc/cron.d/crontab

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/crontab

# Apply cron job
RUN crontab /etc/cron.d/crontab

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Added supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisor.conf

CMD ["/usr/bin/supervisord", "-n"]
