include .env

USER := "www-data"
OS := $(shell uname -s)

DC := $(shell command -v docker-compose 2> /dev/null)
DC += -f docker-compose.yml

PHP_EXEC := $(DC) exec php-fpm
PGSQL_EXEC := $(DC) exec pgsql
MONGO_EXEC := $(DC) exec mongodb

SCHEMA_NAME := "public"
PG_BACKUP_NAME := "dump.backup"

MONGO_BACKUP_NAME := "dump.mongodb"

.PHONY: restore-pg \
	restore-mongo \
	xdebug \
	test \
	test-coverage

xdebug: ## Enable xdebug
	$(DC) exec php-fpm /bin/bash -c 'apt-get update' && \
	$(DC) exec php-fpm /bin/bash -c 'apt-get install psmisc' && \
	$(DC) exec php-fpm /bin/bash -c 'docker-php-ext-enable xdebug && killall -USR2 php-fpm' && \
	echo "Xdebug installed successfully.";\

test: ## Run tests
	$(DC) exec php-fpm /bin/bash -c 'XDEBUG_MODE=coverage php artisan test'

test-coverage: ## Run tests with HTML coverage
	$(DC) exec php-fpm /bin/bash -c 'XDEBUG_MODE=coverage  php artisan test --coverage'


restore-pg: ## Restore from backup (postgre).
	@if [ -e dumps/pg/$(PG_BACKUP_NAME) ]; then \
                $(PGSQL_EXEC) /bin/bash -c '\
                psql -U $(DB_USERNAME) \
                -d $(DB_DATABASE) \
                -c "DROP SCHEMA IF EXISTS $(SCHEMA_NAME) CASCADE;"'; \
                $(PGSQL_EXEC) /bin/bash -c '\
                psql -U $(DB_USERNAME) \
                -d $(DB_DATABASE) \
                -c "CREATE SCHEMA $(SCHEMA_NAME); ALTER SCHEMA $(SCHEMA_NAME) OWNER TO $(DB_USERNAME);"'; \
        		$(PGSQL_EXEC) /bin/bash -c 'pg_restore \
        			--host "localhost" \
        			--port "$(DB_PORT)"\
        			--username "$(DB_USERNAME)"\
        			--no-password \
        			--role "$(DB_USERNAME)" \
        			--dbname "$(DB_DATABASE)" \
        			--verbose \
        			--schema "$(SCHEMA_NAME)" \
        			"/dump/$(PG_BACKUP_NAME)"'; \
				echo "Backup imported successfully.";\
    	else \
    		echo "File $(PG_BACKUP_NAME) not found"; \
    		exit 1; \
    	fi

restore-mongo: ## Restore from backup (MongoDB).
	@if [ -e dumps/mongo/$(MONGO_BACKUP_NAME) ]; then \
		$(MONGO_EXEC) /bin/bash -c 'mongorestore \
			--host localhost \
			--port $(MONGO_PORT) \
			--username $(MONGO_USER) \
			--password $(MONGO_PASSWORD) \
			--db $(MONGO_DATABASE) \
			--drop \
			/dump/$(MONGO_BACKUP_NAME)"'; \
		echo "MongoDB backup imported successfully.";\
	else \
		echo "File $(MONGO_BACKUP_NAME) not found"; \
		exit 1; \
	fi
