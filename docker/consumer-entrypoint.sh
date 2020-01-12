#!/bin/bash

cd /var/www/microservice
rm -Rf var/cache
php bin/console command_consumer
