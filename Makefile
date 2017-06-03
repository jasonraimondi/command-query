default: validate

validate:
	cd domain; vendor/bin/doctrine orm:validate-schema

create-schema:
	cd domain; vendor/bin/doctrine orm:schema-tool:create --dump-sql

update-schema:
	cd domain; vendor/bin/doctrine orm:schema-tool:update --dump-sql

.PHONY: validate create-schema update-schema



