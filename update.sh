#!/bin/sh

git pull
php composer.phar install
php app/console doctrine:schema:update --force
php app/console cache:clear

