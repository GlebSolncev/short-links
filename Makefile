dc := $(shell command -v docker-compose 2>/dev/null)
args = $(filter-out $@,$(MAKECMDGOALS))
NGINX_PORT=8000
MYSQL_PORT=3360
CODE=$(shell command curl -o /dev/null -s -w "%{http_code}\n" http://localhost:8000/short-link)

define print_info
	printf "\033[30;107m %s  \033[0m\n" $1
endef
define print_block
	printf " \e[30;31;5;82m  %s  \033[0m\n" $1
endef

.PHONY : help init build down up restart ps logs cli top url stop migrate
.SILENT : help init build down up restart ps logs cli top url stop migrate
.DEFAULT_GOAL : help

help: ## Show this help
	printf "\033[33m%s:\033[0m\n" 'Available commands'
	awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: ## Make full application initialization (build, up)
	$(dc) build
	$(dc) up --no-start
	$(dc) start

url:
	$(call print_block, 'Laravel('$(CODE)')         ⇒ http://localhost:$(NGINX_PORT)/short-link  ')

migrate:
	$(call print_info, 'migrate')
	@$(dc) run app sh -c "php artisan --no-ansi --no-interaction migrate --force"
	$(call print_info, 'migrated')

build: ## Build project
	$(dc) exec build

down: ## Build project
	$(dc) down

up: ## Start project
	$(dc) start
	@$(dc) run app sh -c "php artisan opti:cle"
	$(MAKE) url

restart: ## Restart project
	$(dc) restart

stop: ## stop docker composer
	$(dc) stop

ps: ## List services
	$(dc) ps

logs: ## get logs  by $servce_name
	$(dc) logs  --tail=100 --follow $(call args)

cli: ## Get cli in $servce_name
	$(dc) exec $(call args) /bin/sh

top: ## List running processes
	$(dc) top