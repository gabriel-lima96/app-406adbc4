FROM php:8.1-fpm AS backend

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

USER root

RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user

EXPOSE 9000

FROM backend AS composer

# Get latest Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENTRYPOINT ["composer"]
