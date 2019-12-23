#!/bin/bash

cd /var/www/microservice
rm -Rf var/
php bin/console command_consumer
