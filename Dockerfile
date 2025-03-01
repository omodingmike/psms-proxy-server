# Use the official PHP image as the base image
FROM php:8.1-rc-zts-alpine3.16

# specifies a working directory for our source code
WORKDIR /app

# copies your source code files along with the package file
COPY . /app

COPY start.sh /start.sh
RUN chmod +x /start.sh

# install composer in your container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install PHP PDO mySQL extension
RUN docker-php-ext-install pdo_mysql

# install dependencies
RUN composer install

# specifies a port number for our image to run in a docker container
EXPOSE 8181

# command to run our docker image in container
CMD ["/start.sh"]

