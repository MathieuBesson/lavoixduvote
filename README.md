# La Voix du Vote

## Prerequisites

![Docker](https://img.shields.io/badge/Docker-v20-2496ED?logo=docker&logoColor=white&labelColor=2496ED&color=white)
![Docker Compose](https://img.shields.io/badge/Docker--Compose-v1-2496ED?logo=docker&logoColor=white&labelColor=2496ED&color=white)
![Make](https://img.shields.io/badge/Make-v4-427819?logo=gnu&logoColor=white&labelColor=427819&color=white)

## Usage

### Initial Setup

`make start`: Pulls the containers and installs dependencies via Composer.

The project will then be accessible at [http://localhost:3000](http://localhost:3000).

### Useful commands

#### Docker Commands

`make up`: Starts the containers.

`make recreate`: Recreates the containers.

`make rebuild`: Rebuilds the containers.

#### Composer Commands

`make composer $args`: Runs a Composer command.

For example: `make composer install`.

*To use long arguments, enclose them in double quotes:*

`make composer "update symfony/* --with-dependencies"`

#### Symfony Console

`make symfony $args`: Runs a Symfony console command.

For example: `make symfony cache:clear`.

*To use long arguments, enclose them in double quotes:*

`make symfony "doctrine:schema:update --dump-sql"`

#### Webpack Encore

`make npm run dev`: Compiles assets.

`make npm run watch`: Starts the frontend watcher (re-compiles assets on every change).

#### Production Deployment

`make deploy $context`: Deploys the project to production. The `$context` argument corresponds to the directory name in `/var/www/`.

For example, to deploy the changes to the project hosted in `/var/www/preprod`, run:

`make deploy preprod`

## License

See the [LICENSE](./LICENSE) file for details.
