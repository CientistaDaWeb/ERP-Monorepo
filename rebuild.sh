#!/bin/bash
set -e

docker-compose down
sudo chmod 777 -Rf .docker/mysql/dbdata
docker-compose build
docker-compose up -d
