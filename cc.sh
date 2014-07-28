#!/bin/sh

sudo chmod -R 777 app/cache/
php app/console cache:clear
mkdir app/cache/dev
sudo chmod -R 777 app/cache/

