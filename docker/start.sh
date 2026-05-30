#!/bin/bash
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan migrate --force
php artisan db:seed --force
php-fpm -D
nginx -g "daemon off;"