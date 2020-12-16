# Aplicacion web para genetista

## Requirements

    * php 7.4 
        1 - can use the php with xamp or wamp if you are windows
        2 - if in ubuntu (exec sudo apt install php7.4 , sudo apt install php7.4-fpm )
        3 - can use docker ( with laradock maybe)
    * Composer https://getcomposer.org/
    * Symfony Cli https://symfony.com/download

## Utils Commands a

    * symfony server:start
    * php bin/console make:controller
    * php bin/console make:entity
    * php bin/console make:form
    * php bin/console make:service
    * php bin/console doctrine:schema:update --dump-sql
    * php bin/console doctrine:schema:update --force
    * composer install
    * composer update
    for migrations 
    * php bin/console make:migration
    * php bin/console doctrine:migrations:migrate
    for load user fixtures
    * php bin/console doctrine:fixtures:load (carefull will prune your database)
-----------
<!-- 
cd .\genetista\
symfony server:start -d

GIT
git add .
git commit -m "nombre"
git pull
git push 
--># genetista
