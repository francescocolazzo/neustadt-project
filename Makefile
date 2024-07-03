run-app:
	if ! [ -f ./src/.env ];then cp  ./src/.env.example ./src/.env ;fi
	docker compose build
	docker compose up -d
	docker exec php /bin/sh -c "composer install && npm install && chmod -R 777 storage && php artisan key:generate && php artisan migrate:fresh --seed &&  php artisan storage:link"

shell-php: 
	docker exec -it  php   /bin/sh

shell-mysql: 
	docker exec -it  mysql /bin/sh

shell-react:
	docker exec -it  react /bin/sh