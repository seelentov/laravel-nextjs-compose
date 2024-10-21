include .env

# Инициализация проекта
init:
	# Создает файл .env, если он отсутствует, создает ссылку
	@make env
	# Строит и запускает контейнеры в фоновом режиме
	docker compose up -d --build
	# Устанавливает зависимости проекта
	docker compose exec app composer install
	# Устанавливает Filament
	docker compose exec app php artisan filament:install --scaffold --tables --forms
	# Очищает базу данных и запускает миграции
	@make fresh
	# Создает администратора
	@make seed-admin
	# Запускает воркеров в фоновом режиме
	docker compose --profile workers up -d
	# Приостанавливает супервайзер
	docker compose exec horizon php artisan horizon:pause-supervisor supervisor-test
	# Генерирует ключ приложения
	docker compose exec app php artisan key:generate
	# Создает символические ссылки для директории storage
	docker compose exec app php artisan storage:link
	# Устанавливает права доступа для директории storage
	docker compose exec app chmod -R 777 storage bootstrap/cache

# Запуск контейнеров
up:
	# Запускает все сервисы в фоновом режиме
	docker compose --profile "*" up -d
	# Приостанавливает супервайзер
	docker compose exec horizon php artisan horizon:pause-supervisor supervisor-test

# Остановка контейнеров
stop:
	docker compose stop

# Остановка и удаление контейнеров
down:
	docker compose --profile "*" down --remove-orphans

# Остановка и удаление контейнеров с томами
down-v:
	docker compose down --remove-orphans --volumes

# Удаление проекта
destroy:
	# Останавливает и удаляет контейнеры, образы, тома и орфаны
	docker compose --profile "*" down --rmi all --volumes --remove-orphans

# Перезапуск контейнеров
restart:
	@make down
	@make up

# Пересоздание проекта
remake:
	@make destroy
	@make init

# Запуск миграций
migrate:
	docker compose exec app php artisan migrate

# Заполнение базы данных тестовыми данными
seed:
	docker compose exec app php artisan db:seed

# Заполнение базы данных тестовыми данными, включая администратора
seed-admin:
	docker compose exec app php artisan db:seed --class=AdminSeeder

# Очистка базы данных и запуск миграций
fresh:
	docker compose exec app php artisan migrate:fresh

# Запуск тестов
test:
	docker compose exec app php artisan test

# Вывод логов для всех контейнеров
logs:
	docker compose logs

# Вывод логов для всех контейнеров с отслеживанием вывода
watch:
	docker compose logs --follow

# Вывод логов для nginx
web-logs:
	docker compose logs nginx

# Вывод логов для nginx с отслеживанием вывода
web-watch:
	docker compose logs nginx --follow

# Перезагрузка конфигурации nginx
nginx-reload:
	sudo docker compose exec nginx nginx -t && sudo docker compose exec nginx nginx -s reload

# Вывод логов для next.js
next-logs:
	docker compose logs next

# Вывод логов для next.js с отслеживанием вывода
next-watch:
	docker compose logs next --follow

# Перестройка приложения next.js
next-rebuild:
	@make next-clear
	docker compose exec next npm run build

# Очистка директории сборки next.js
next-clear:
	rm -rf ./next/.next

# Вывод логов для контейнера app
app-logs:
	docker compose logs app

# Вывод логов для контейнера app с отслеживанием вывода
app-watch:
	docker compose logs app --follow

# Вывод логов для elasticsearch
es-logs:
	docker compose logs elasticsearch

# Вывод логов для elasticsearch с отслеживанием вывода
es-watch:
	docker compose logs elasticsearch --follow

# Вывод статуса Horizon
horizon-status:
	docker compose exec horizon php artisan horizon:status

# Приостановка Horizon
horizon-pause:
	docker compose exec horizon php artisan horizon:pause

# Возобновление работы Horizon
horizon-continue:
	docker compose exec horizon php artisan horizon:continue

# Вывод логов Horizon
horizon-logs:
	docker compose logs horizon

# Вывод логов Horizon с отслеживанием вывода
horizon-watch:
	docker compose logs horizon --follow

# Вывод логов планировщика задач
schedule-logs:
	docker compose logs schedule

# Вывод логов планировщика задач с отслеживанием вывода
schedule-watch:
	docker compose logs schedule --follow

# Создание файла .env, если он отсутствует
env:
	# Проверяет, существует ли файл .env
	@if [ ! -f .env ]; then \
	  # Копирует файл .env.example в .env
	  cp .env.example .env; \
	fi

# Установка переменных окружения
setenv:
	# Пример:
	# @make setenv APP_ENV=production
	# Добавляет переменную окружения в файл .env
	echo "export $1=$2" >> .env

# Открыть bash-консоль в контейнере app
bash:
	docker compose exec app bash

# Открыть bash-консоль в контейнере next.js
next-bash:
	docker compose exec next bash

# Открыть консоль MySQL
mysql:
	docker compose exec db mysql -u root

# Сделать дамп базы данных MySQL
mysqldump:
	docker compose exec db mysqldump -u root ${DB_DATABASE} > ${DB_DATABASE}.sql

# Открыть консоль PostgreSQL
psql:
	 sudo docker compose exec db psql -h ${DB_HOST} -p ${DB_PORT} -d ${DB_DATABASE} -U ${DB_USERNAME}

# Сделать дамп базы данных PostgreSQL
pgdump:
	sudo docker compose exec db pg_dump -h ${DB_HOST} -p ${DB_PORT} -d ${DB_DATABASE} -U ${DB_USERNAME} > ${DB_DATABASE}.dump

# Сгенерировать секретный ключ JWT
jwt:
	docker compose exec app php artisan jwt:secret

# Показать запущенные контейнеры
ps:
	docker compose ps

# Откатить базу данных к начальному состоянию
rollback-test:
	docker compose exec app php artisan migrate:fresh
	docker compose exec app php artisan migrate:refresh

# Подготовить приложение к продакшену
prepare:
	@make optimize
	@make cache

# Очистить кэш и оптимизированные файлы
clear:
	@make optimize-clear
	@make cache-clear

# Оптимизировать приложение
optimize:
	docker compose exec app php artisan optimize
# Очистить оптимизированные файлы
optimize-clear:
	docker compose exec app php artisan optimize:clear
# Закешировать приложение
cache:
	docker compose exec app composer dump-autoload -o
	@make optimize
	docker compose exec app php artisan event:cache
	docker compose exec app php artisan view:cache
# Очистить кэш
cache-clear:
	docker compose exec app composer clear-cache
	@make optimize-clear
	docker compose exec app php artisan event:clear
# Сгенерировать автозагрузчик Composer
dump-autoload:
	docker compose exec app composer dump-autoload

# Связать файл .env с контейнерами Laravel и Next.js
env:
	touch .env
	rm -rf ./laravel/.env
	rm -rf ./next/.env
	ln .env ./laravel
	ln .env ./next

# Открыть консоль Redis
redis:
	docker compose exec redis redis-cli

# Проверить, работает ли приложение
check:
	curl -s -o /dev/null -w "%{http_code}\n" http://localhost

# Переиндексировать ElasticSearch
elastic-reindex:
	docker compose exec app php artisan search:reindex

# Создать резервную копию базы данных и файлов приложения
backup:
	tar -czvf backups/$(shell date +"%d-%m-%Y-%H:%M:%S").tar.gz --exclude=backups/* docker/*

# Сгенерировать SSL-сертификаты
ssl:
	docker compose exec nginx apt update
	docker compose exec nginx apk add certbot certbot-nginx
	docker compose exec nginx certbot --nginx

# Настроить брандмауэр UFW
ufw:
	apt install ufw
	ufw allow ssh
	ufw allow http
	ufw allow https
	ufw enable
