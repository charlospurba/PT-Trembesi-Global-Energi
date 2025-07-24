#!/usr/bin/env bash
set -e

composer install
php artisan migrate --force
php artisan config:cache
