
# Laravel 11 test-swc

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

* Makefile described below is usefull for operating systems of the UNIX family.
To build and run the project, through terminal enter into project directory and launch the command:
make run-app


*  To build and run the project for Windows, through terminal enter into project directory and launch the command:
- copy .\src\.env.example .\src\.env
- docker-compose build
- docker-compose up -d
- composer install && npm install && chmod -R 777 storage && php artisan key:generate && php artisan migrate:fresh --seed &&  php artisan storage:link


* Web app available at http://localhost:3000/ 