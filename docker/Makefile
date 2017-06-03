default: build

start:
	docker-compose up -d
	docker-compose ps

stop:
	docker-compose stop

status:
	docker-compose ps

restart: stop start

top:
	docker-compose top

stats:
	docker stats --format "table {{.Name}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.MemPerc}}\t{{.NetIO}}\t{{.BlockIO}}" --no-stream

stats-stream:
	docker stats --format "table {{.Name}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.MemPerc}}\t{{.NetIO}}\t{{.BlockIO}}"

clean: stop
	docker-compose rm

build:
	docker-compose build

pull:
	docker-compose pull

push:
	docker-compose push

tail:
	docker-compose logs -f

php:
	docker-compose exec php bash

redis:
	docker-compose exec redis redis-cli

yarn:
	docker-compose exec yarn bash -c "yarn install"

composer:
	docker-compose exec php bash -c "composer install"

npm-dev:
	docker-compose exec yarn bash -c "npm run dev"

npm-prod:
	docker-compose exec yarn bash -c "npm run prod"

.PHONY: start stop status restart top stats stats-stream clean build pull tail php redis npm-dev npm-prod composer
