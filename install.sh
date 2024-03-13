#!/bin/bash

echo "Building Docker container..."
docker-compose build &&

echo "Starting Docker containers..."
docker-compose up -d &&

sleep 10 &&

echo "Installing Composer dependencies..."
docker-compose exec app composer install &&

if [ ! -f ".env" ]; then
    echo "Copying .env.example to .env..."
    docker-compose exec app cp .env.example .env
fi &&

echo "Generating Laravel key..."
docker-compose exec app php artisan key:generate &&

echo "Generating Laravel migrations..."
docker-compose exec app php artisan migrate &&

echo "Updating storage and cache permissions..."
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache &&

echo "Project initialization complete."
