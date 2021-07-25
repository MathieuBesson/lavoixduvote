# La Voix du Vote

## Environnement de développement 

### Prérequis

- docker
- docker-compose
- make

### Utilisation

#### Première installation

`make start` : pull les containers + composer install.

Le projet est ensuite accessible à l'adresse http://localhost:3000

#### Au quotidien...

##### Docker

`make up` : lance les containers

`make recreate` : recrée les containers

`make rebuild` : rebuild les containers

##### Composer

`make composer $args` : Lance une commande composer. 

Par ex. : `make composer install`. 

*Pour utiliser des arguments longs, utiliser des doubles quotes :*

`make composer "update symfony/* --with-dependencies"`

##### Symfony console

`make symfony $args` : Lance une commande de la console Symfony.

Par ex. : `make symfony cache:clear`.

*Pour utiliser des arguments longs, utiliser des doubles quotes :*

`make symfony "doctrine:schema:update --dump-sql"`

##### Webpack Encore

`make npm run dev` : Compilation des assets

`make npm run watch` : Lancement du serveur front en observer (re-compilation des assets à chaque modification)

##### Mise en production

`make deploy $context` : Mise en production. L'argument $context correspond au nom du dossier dans /var/www/.
                         Par exemple, si on envoyer en prod les modifications du projet hébergé dans /var/www/preprod
                         Il suffira de faire `make deploy preprod`