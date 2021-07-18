## start	: 	Start containers and prepare a dev environment
.PHONY: start
start:	up
		$(MAKE) composer install
		$(MAKE) symfony doctrine:migrations:migrate
		$(MAKE) symfony doctrine:fixtures:load
		$(MAKE) npm install
		$(MAKE) npm run dev

## up		:	Start up containers.
.PHONY: up
up:
	docker-compose pull
	docker-compose up -d --remove-orphans

## stop		:	Stop containers.
.PHONY: stop
stop:
	@docker-compose stop

## prune	:	Remove containers and their volumes.
##		You can optionally pass an argument with the service name to prune single container
##		prune mariadb	: Prune `mariadb` container and remove its volumes.
##		prune mariadb solr	: Prune `mariadb` and `solr` containers and remove their volumes.
.PHONY: prune
prune:
	@docker-compose down -v $(filter-out $@,$(MAKECMDGOALS))

## recreate	:	Remove containers and their volumes and recreate them
.PHONY: recreate
recreate:
	docker-compose down
	docker-compose up --force-recreate -d

## rebuild	:	Remove containers and their volumes and rebuild them
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

## npm		:	Executes `npm` command
##		To use "--flag" arguments include them in quotation marks.
##		For example: make composer "npm run --prefix /var/www/lavoixduvote"
.PHONY: npm
npm:
	docker-compose run --rm node npm $(filter-out $@,$(MAKECMDGOALS))

## symfony	:	Executes `php bin/console` command
##		To use "--flag" arguments include them in quotation marks.
##		For example: make symfony "doctrine:schema:update --dump-sql"
.PHONY: symfony
symfony:
	docker-compose exec php /var/www/html/bin/console $(filter-out $@,$(MAKECMDGOALS))

# deploy 	: 	Pull, install dependencies, compile assets
## 		Mandatory argument is for folder's name in /var/www
##		e.g: "make deploy preprod" for deploying to /var/www/preprod
.PHONY: deploy
deploy:
	sudo -u www-data -H git pull
	sudo -u www-data -H composer install --working-dir=/var/www/$(filter-out $@,$(MAKECMDGOALS))/symfony
	cd /var/www/$(filter-out $@,$(MAKECMDGOALS))/symfony && sudo -u www-data -H npm install
	cd /var/www/$(filter-out $@,$(MAKECMDGOALS))/symfony && sudo -u www-data -H npm run build

# https://stackoverflow.com/a/6273809/1826109
%:
	@:
