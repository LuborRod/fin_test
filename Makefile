init: docker-down-clear docker-pull docker-build docker-up api-init
up: docker-up
down: docker-down
restart: down up

migrations: api-init-migrations

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

api-init: api-composer-install \
		  api-change-mode-storage \
		  api-config-clear \
		  api-cache-clear \
	      api-init-migrations \
	      fill-test-data

api-composer-install:
	docker-compose run --rm php-cli composer install

api-composer-require:
	docker-compose run --rm php-cli composer require $(arg)

api-composer-remove:
	docker-compose run --rm php-cli composer remove $(arg)

api-init-migrations:
	docker-compose run --rm  php-cli php artisan migrate

api-config-clear:
	docker-compose run --rm  php-cli php artisan config:clear

api-cache-clear:
	docker-compose run --rm  php-cli php artisan cache:clear

api-change-mode-storage:
	docker-compose run --rm  php-cli chmod -R 777 storage/

api-create-migration:
	docker-compose run --rm  php-cli php artisan make:migration $(arg)

api-revert-migrations:
	docker-compose run --rm  php-cli php artisan migrate:reset

mysql:
	docker-compose exec db mysql -u root -ppass

php-script:
	docker-compose run --rm php-cli php artisan $(arg)

fill-test-data:
	docker-compose run --rm php-cli php artisan db:seed
