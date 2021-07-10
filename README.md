# La Voix du Vote

## Environnement de développement 

### Prérequis

- docker
- docker-compose
- make

### Utilisation

#### Première installation

`make start` : pull les containers + composer install
Le projet est ensuite accessible à l'adresse http://localhost:3000

#### Au quotidien...

##### Docker

`make up` : lance les containers

`make recreate` : rebuild les containers

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

