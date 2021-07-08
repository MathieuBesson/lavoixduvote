COMPOSER_ROOT ?= /var/www/html
SYMFONY_ROOT ?= /var/www/html/public

## up	:	Start up containers.
.PHONY: up
up:
	@echo "Starting up containers for lavoixduvote..."
	docker-compose pull
	docker-compose up -d --remove-orphans

## stop	:	Stop containers.
.PHONY: stop
stop:
	@echo "Stopping containers for lavoixduvote..."
	@docker-compose stop

## prune	:	Remove containers and their volumes.
##		You can optionally pass an argument with the service name to prune single container
##		prune mariadb	: Prune `mariadb` container and remove its volumes.
##		prune mariadb solr	: Prune `mariadb` and `solr` containers and remove their volumes.
.PHONY: prune
prune:
	@echo "Removing containers for lavoixduvote..."
	@docker-compose down -v $(filter-out $@,$(MAKECMDGOALS))

## recreate	:	Remove containers and their volumes and recreate them
.PHONY: recreate
recreate: prune up

## composer	:	Executes `composer` command in a specified `COMPOSER_ROOT` directory.
##		To use "--flag" arguments include them in quotation marks.
##		For example: make composer "update symfony/* --with-dependencies"
.PHONY: composer
composer:
	docker run -it $(shell docker ps -a --filter name='^/lavoixduvote_composer' --format "{{ .Image }}") $(filter-out $@,$(MAKECMDGOALS))
