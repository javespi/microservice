#!/bin/bash

cd /var/www/microservice
rm -Rf var/
php -S 0.0.0.0:8200 -t public
