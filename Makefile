dc := $(shell command -v docker-compose 2>/dev/null)
args = $(filter-out $@,$(MAKECMDGOALS))
NGINX_PORT=8000
MYSQL_PORT=3360


define print
	printf " \033[33m[%s]\033[0m \033[32m%s\033[0m\n" $1 $2
endef
define print_block
	printf " \e[30;48;5;82m  %s  \033[0m\n" $1
endef
define print_danger_block
	printf " \e[30m\e[41m  %s  \e[0m\n" $1
endef

.PHONY : help init build down up restart ps logs cli top url migrate
.SILENT : help init build down up restart ps logs cli top url
.DEFAULT_GOAL : help

help: ## Show this help
	printf "\033[33m%s:\033[0m\n" 'Available commands'
	awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: ## Make full application initialization (build, up)
	@$(dc) build
	@$(dc) up

url:
	$(call print_block, 'Laravel         ⇒ http://localhost:$(NGINX_PORT)  ')

build: ## Build project
	$(dc) exec build

down: ## Build project
	$(dc) down

up: ## Start project
	$(dc) start

restart: ## Restart project
	$(dc) restart

ps: ## List services
	$(dc) ps

logs: ## get logs  by $servce_name
	$(dc) logs  --tail=100 --follow $(call args)

cli: ## Get cli in $servce_name
	$(dc) exec $(call args) /bin/sh

top: ## List running processes
	$(dc) top

migrate:
	$(dc) exec app php artisan migrate