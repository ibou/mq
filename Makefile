# Executables: local only
SYMFONY_BIN   = symfony
DOCKER        = docker
DOCKER_COMP   = docker-compose
SYMFONY       = $(EXEC_PHP) bin/console

HTTP_PORT     = 8000

# Executables
EXEC_PHP      = php
COMPOSER      = composer

## —— 🐝 The Strangebuzz Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	$(SYMFONY) c:c

warmup: ## Warmup the cache
	$(SYMFONY) cache:warmup

fix-perms: ## Fix permissions of all var files
	chmod -R 777 var/*

assets: purge ## Install the assets with symlinks in the public folder
	$(SYMFONY) assets:install public/ --symlink --relative

purge: ## Purge cache and logs
	rm -rf var/cache/* var/logs/*

serve: ## Serve the application with HTTPS support
	$(SYMFONY_BIN) serve -d

unserve: ## Stop the webserver
	$(SYMFONY_BIN) server:stop


## —— Docker 🐳 ————————————————————————————————————————————————————————————————
docker-up: ## Start the docker hub (MySQL,redis,adminer,elasticsearch,head,Kibana)
	$(DOCKER_COMP) up -d

docker-build: ## UP+rebuild the application image
	$(DOCKER_COMP) up -d --build

docker-down: ## Stop the docker hub
	$(DOCKER_COMP) down --remove-orphans

