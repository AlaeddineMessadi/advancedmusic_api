# vim: set tabstop=8 softtabstop=8 noexpandtab:

help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  all            to setup everything at once (including install, migrations)"
	@echo "  run            to run everything"
	@echo "  reset-env      to reset environment to default values"
	@echo "  restart        to restart everything"
	@echo "  stop           to stop everything"
	@echo "  logs           to tail logs of everything"
	@echo "  install        to install everything"
	@echo "  enter          to stop everything"
	@echo "  destroy        to destroy everything (clears docker volumes and images also)"
	@echo "  test-unit      to run unit tests"

run:
	@if [ ! -f "./.env" ]; then\
        cp .env.dist .env; \
    fi
	@if [ ! -f "./app/.env" ]; then\
        cp ./app/.env.dist ./app/.env; \
    fi
	@docker-compose up -d

build:
	@docker-compose build


install:
#	@docker-compose exec api_server_php /bin/sh -c 'chown -R php:php /home/php/.composer/cache'
	@docker exec -it --user="www-data" api_server_php sh -c "composer install"
	@docker exec -it --user="www-data" api_server_php sh -c "bin/console assets:install"
	@docker exec -it --user="www-data" api_server_php sh -c "bin/console doctrine:migration:migrate"
#	@docker-compose exec -T --user="php" api_server_php bin/warm_up

enter:
	@docker exec -it --user="www-data" api_server_php sh

root:
	@docker exec -it --user="root" api_server_php sh

logs:
	@docker-compose logs -f

db:
	@docker exec -it --user="www-data" api_server_php sh -c "bin/console doctrine:schema:create"

enter-nginx:
	@docker-compose exec api_server_nginx sh

destroy:
	@docker-compose down --rmi local

stop:
	@docker-compose stop
