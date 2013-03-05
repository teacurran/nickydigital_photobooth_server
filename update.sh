#!/bin/sh

git pull
php app/console doctrine:schema:update --force
php app/console cache:clear

