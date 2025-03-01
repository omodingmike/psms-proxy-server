#!/bin/sh

# Copy .env.example to .env
cp .env.example .env

# Add database configuration values to .env
echo "DB_HOST=102.134.147.233" >> .env
echo "DB_PORT=32764" >> .env
echo "DB_DATABASE=spawuhbjqgomsoyilplqmwtz" >> .env
echo "DB_USERNAME=rcvtxbsavvksfuzt" >> .env
echo "DB_PASSWORD=i,Ay%sUUfd3u<-GjmraS6bGba=btqj<n" >> .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Serve the application
php artisan serve --host=0.0.0.0 --port=8181
