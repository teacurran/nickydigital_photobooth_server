#!/bin/sh

git pull
php composer.phar install
php app/console doctrine:schema:update --force

php app/console assets:install web --symlink

#php app/console cache:clear

rm -rdf app/cache/dev
