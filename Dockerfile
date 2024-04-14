FROM php:7.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Xdebug
RUN pecl install xdebug-2.9.8 && \
  docker-php-ext-enable xdebug && \
  echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini && \
  echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/php.ini

# Install Composer 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.22

# Create a symbolic link
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
  mkdir -p /home/$user/.composer && \
  chown -R $user:$user /home/$user

# Set user to run commands
USER $user

# Set working directory
WORKDIR /var/www
