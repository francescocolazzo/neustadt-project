
# Laravel 11 Web-app Neustadt

## Goals

* Web application to download cards from the magical world of Scryfall

## Technologies

* Docker
* Nginx
* Mysql
* Redis
* Laravel
* React
 
## Getting Started

To get started with this project, you will need to have on your local machine Docker Desktop (`https://www.docker.com/products/docker-desktop`).

## For UNIX-based Operating Systems
- Open a terminal.
- Navigate to the project directory.
- Run the following command: make run-app


## For Windows
- Open a terminal.
- Navigate to the project directory.
- Into folder src duplicate .env.example and rename the new file in .env

- Go back into project directory (neustadt-project) and run the following command:
- docker-compose build
- docker-compose up -d
- docker exec -it php /bin/sh 

Inside PHP CONTAINER:
- composer install && npm install && chmod -R 777 storage && php artisan key:generate && php artisan migrate:fresh --seed &&  php artisan storage:link


* Web app available at http://localhost:3000/ 