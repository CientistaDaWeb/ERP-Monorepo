#!/bin/sh
set -e

COMPOSER_MEMORY_LIMIT=-1 composer install -o && php-fpm
