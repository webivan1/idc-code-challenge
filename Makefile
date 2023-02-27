up:
	docker-compose up -d

down:
	docker-compose down

php-console:
	docker-compose exec idc-php bash

generate-key:
	docker-compose exec idc-php bin/console lexik:jwt:generate-keypair

fixture:
	docker-compose exec idc-php bin/console doctrine:migrations:migrate
	docker-compose exec idc-php bin/console doctrine:fixtures:load -n --append
