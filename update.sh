#!/bin/bash

cd /var/www/laravel

git fetch

git checkout main

git pull

npm install && npm run prod

composer install --optimize-autoloader --no-dev

php artisan optimize
