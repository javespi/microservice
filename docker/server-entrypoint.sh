#!/bin/bash

cd /var/www/microservice
rm -Rf var/
php vendor/bin/ppm start --host 0.0.0.0 --port 8200 --workers 5 --bootstrap Symfony --bridge HttpKernel --app-env=dev
