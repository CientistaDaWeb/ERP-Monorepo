#!/bin/sh
set -e

composer install -o && php-fpm
