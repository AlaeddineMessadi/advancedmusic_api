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
	@docker-compose up -d

build:
	@docker-compose build

install:
	@docker-compose exec -T ovm-tester /bin/sh -c 'chown -R php:php /home/php/.composer/cache'
	@docker-compose exec --user="php" ovm-tester composer install
	@docker-compose exec -T --user="php" ovm-tester bin/warm_up

enter:
	@docker-compose exec --user="php" ovm-tester /bin/sh

enter-nginx:
	@docker-compose exec ovm-tester-nginx /bin/sh

destroy:
	@docker-compose down --rmi local

stop:
	@docker-compose stop
