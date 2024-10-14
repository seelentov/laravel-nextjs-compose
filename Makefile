#!make
include .env

destroy:
	docker compose down --rmi all --volumes --remove-orphans

init:
	docker compose up -d
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link
	docker compose exec app chmod -R 777 storage bootstrap/cache
    # @make jwt

up:
	docker compose up -d

stop:
	docker compose stop

down:
	docker compose down --remove-orphans

down-v:
	docker compose down --remove-orphans --volumes

restart:
	@make down
	@make up

remake:
	@make destroy
	@make init

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

fresh:
	docker compose exec app php artisan migrate:fresh

test:
	docker compose exec app php artisan test

logs:
	docker compose logs

watch:
	docker compose logs --follow

bash:
	docker compose exec app bash

mysql:
	docker compose exec db mysql -u root -p

mysqldump:
	docker compose exec db mysqldump -u root -p ${DB_DATABASE} > ${DB_DATABASE}.sql
	
jwt:
	docker compose exec app php artisan jwt:secret

ps:
	docker compose ps

rollback-test:
	docker compose exec app php artisan migrate:fresh
	docker compose exec app php artisan migrate:refresh

prepare:
	@make optimize
	@make cache

clear:
	@make optimize-clear
	@make cache-clear

optimize:
	docker compose exec app php artisan optimize
optimize-clear:
	docker compose exec app php artisan optimize:clear
cache:
	docker compose exec app composer dump-autoload -o
	@make optimize
	docker compose exec app php artisan event:cache
	docker compose exec app php artisan view:cache
cache-clear:
	docker compose exec app composer clear-cache
	@make optimize-clear
	docker compose exec app php artisan event:clear
dump-autoload:
	docker compose exec app composer dump-autoload

env:
	cp -rf .env ./laravel 

redis:
	docker compose exec redis redis-cli

