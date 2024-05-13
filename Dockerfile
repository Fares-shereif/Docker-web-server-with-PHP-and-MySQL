# Use an official PHP Apache image as a parent image
FROM php:apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the local directory contents into the container at /var/www/html
COPY . /var/www/html
