.PHONY: start
start:	up
		$(MAKE) composer install

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
recreate:
	docker-compose down
	docker-compose up --force-recreate -d

## rebuild:		Remove containers and their volumes and rebuild them
.PHONY: rebuild
rebuild:
	docker-compose down
	docker-compose up --build -d

## composer	:	Executes `composer` command
##		To use "--flag" arguments include them in quotation marks.
##		For example: make composer "update symfony/* --with-dependencies"
.PHONY: composer
composer:
	docker run --rm --interactive --tty --volume ${shell pwd}/symfony:/var/www/html $(shell docker ps -a --filter name='^/lavoixduvote_composer' --format "{{ .Image }}") $(filter-out $@,$(MAKECMDGOALS))

## symfony	:	Executes `php bin/console` command
##		To use "--flag" arguments include them in quotation marks.
##		For example: make symfony "doctrine:schema:update --dump-sql"
.PHONY: symfony
symfony:
	docker-compose exec php /var/www/html/bin/console $(filter-out $@,$(MAKECMDGOALS))

# https://stackoverflow.com/a/6273809/1826109
%:
	@:
