default: validate

start:
	cd docker; docker-compose up -d
	cd docker; docker-compose ps

stop:
	cd docker; docker-compose stop

status:
	cd docker; docker-compose ps

restart: stop start

validate:
	cd domain; vendor/bin/doctrine orm:validate-schema

create-schema:
	cd domain; vendor/bin/doctrine orm:schema-tool:create --dump-sql

update-schema:
	cd domain; vendor/bin/doctrine orm:schema-tool:update --dump-sql

composer-update:
	cd domain; composer update; cd ../lumen-api; composer update; cd ../lumen-auth; composer update

.PHONY: validate create-schema update-schema
