FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    libxml2-dev \
    locales \
    libfreetype6-dev \
    jpegoptim optipng pngquant gifsicle \
    zip \
    vim \
    unzip \
    libzip-dev

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Install Node js
RUN apt-get update && apt-get install -y nodejs npm

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www
COPY ./ /var/www/
COPY --chown=$user . /var/www
RUN chown -R $user:$user /var/www

USER $user

# Install composer
RUN composer install --no-cache

# Clear project cache and config cache
RUN php artisan cache:clear 
RUN php artisan config:clear

RUN npm install
RUN npm run build

CMD bash -c "composer install && php artisan serve --host 0.0.0.0 --port 5001"
