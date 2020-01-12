DOCKER_COMPOSE = "docker-compose"
DOCKER_COMPOSE_FILE = "docker/dev/compose.yml"
DEFAULT_SERVICE = "microservice"
DOCKER_COMPOSE_COMMAND = $(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE)
DOCKER_APP_RUN = $(DOCKER_COMPOSE_COMMAND) exec $(DEFAULT_SERVICE)
SYMFONY_CONSOLE = bin/console
RUN_OPTIONS = -e ENV=dev -e userid=$(shell id -u)
DOCKER_COMPOSE_COMMAND = $(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE)
DOCKER_APP_RUN = $(DOCKER_COMPOSE_COMMAND) run $(RUN_OPTIONS) $(DEFAULT_SERVICE)
DOCKER_APP_EXEC = $(DOCKER_COMPOSE_COMMAND) exec  $(DEFAULT_SERVICE)

.PHONY: help
help:       		## Show help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

.PHONY: build
build:      		## Build the development container image
	$(DOCKER_COMPOSE_COMMAND) build

.PHONY: up
up:         		## Start docker compose containers. Optionally pass arguments with ARGS. Example: make up ARGS="-d"
	$(DOCKER_COMPOSE_COMMAND) up $(ARGS)

.PHONY: down
down:       		## Stop docker compose containers.
	$(DOCKER_COMPOSE_COMMAND) down

.PHONY: stop
stop:       		## Stop docker compose containers.
	$(DOCKER_COMPOSE_COMMAND) stop

.PHONY: run
run:        		## Run any command inside the container. Use as make run ARGS="ls"
	$(DOCKER_APP_RUN) $(ARGS)

.PHONY: shell
shell:      		## Start a shell inside the container.
	$(DOCKER_APP_EXEC) bash

.PHONY: consol
console:    		## Run the symfony console. Use as make console ARGS="cache:clear"
	$(DOCKER_APP_RUN) $(SYMFONY_CONSOLE) $(ARGS)

.PHONY: composer-install
composer-install:   	## Run composer install
	$(DOCKER_APP_RUN) php -d memory_limit=-1 composer.phar install --no-scripts

.PHONY: cache-clear
cache-clear:		## Run console cache:clear
	$(DOCKER_APP_RUN) $(SYMFONY_CONSOLE) cache:clear

.PHONY: tests
tests:      		## Run the unit tests.
	$(DOCKER_APP_RUN) bin/phpunit --configuration phpunit.xml.dist

.PHONY: cs
cs:			## Run PHP Code Fixer and automatically fix issues in modified files
	git --no-pager diff --name-only --diff-filter=ACM HEAD -- | grep .php | xargs -n1 vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --diff --using-cache=no

.PHONY: stan
stan:			## Run PHPStan static code analysis for type errors on modified files
	git --no-pager diff --name-only --diff-filter=ACM HEAD -- | grep .php | xargs -n1 vendor/phpstan/phpstan/bin/phpstan analyse -c phpstan.neon --level max

