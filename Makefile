#!make
include .env

destroy:
	docker compose --profile "*" down --rmi all --volumes --remove-orphans

init:
	@make env
	docker compose up -d --build
	docker compose exec app composer install
	docker compose exec app php artisan filament:install --scaffold --tables --forms
	@make fresh
	@make seed-admin
	docker compose --profile workers up -d 
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link
	docker compose exec app chmod -R 777 storage bootstrap/cache
# @make jwt

up:
	docker compose --profile "*" up -d

horizon-status:
	docker compose exec horizon php artisan horizon:status

horizon-pause:
	docker compose exec horizon php artisan horizon:pause

horizon-continue:
	docker compose exec horizon php artisan horizon:continue

horizon-logs:
	docker compose logs horizon

horizon-watch:
	docker compose logs horizon --follow

schedule-logs:
	docker compose logs schedule

schedule-watch:
	docker compose logs schedule --follow

stop:
	docker compose stop

down:
	docker compose --profile "*" down --remove-orphans

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

seed-admin:
	docker compose exec app php artisan db:seed --class=AdminSeeder

fresh:
	docker compose exec app php artisan migrate:fresh

test:
	docker compose exec app php artisan test

logs:
	docker compose logs

watch:
	docker compose logs --follow

web-logs:
	docker compose logs nginx

web-watch:
	docker compose logs nginx --follow

nginx-reload:
	sudo docker compose exec nginx nginx -t && sudo docker compose exec nginx nginx -s reload

next-logs:
	docker compose logs next

next-watch:
	docker compose logs next --follow

next-rebuild:
	@make next-clear
	docker compose exec next npm run build

next-clear:
	rm -rf ./next/.next
	
app-logs:
	docker compose logs app

app-watch:
	docker compose logs app --follow

bash:
	docker compose exec app bash

next-bash:
	docker compose exec next bash

mysql:
	docker compose exec db mysql -u root

mysqldump:
	docker compose exec db mysqldump -u root ${DB_DATABASE} > ${DB_DATABASE}.sql

psql:
	sudo docker compose exec db psql -h ${DB_HOST} -p ${DB_PORT} -d ${DB_DATABASE} -U ${DB_USERNAME}

pgdump:
	sudo docker compose exec db pg_dump -h ${DB_HOST} -p ${DB_PORT} -d ${DB_DATABASE} -U ${DB_USERNAME} > ${DB_DATABASE}.dump

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
	touch .env
	rm -rf ./laravel/.env
	rm -rf ./next/.env
	ln .env ./laravel
	ln .env ./next

redis:
	docker compose exec redis redis-cli

check:
	curl -s -o /dev/null -w "%{http_code}\n" http://localhost


elastic-reindex:
	docker compose exec app php artisan search:reindex