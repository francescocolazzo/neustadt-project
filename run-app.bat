@echo off
REM Check if .env file exists, if not copy .env.example to .env
if not exist .\src\.env (
    copy .\src\.env.example .\src\.env
)

REM Build Docker containers
docker-compose build

REM Start Docker containers in detached mode
docker-compose up -d

REM Run commands inside the PHP container
docker exec php cmd /C "composer install && npm install && icacls storage /grant Everyone:(F) /T && php artisan key:generate && php artisan migrate:fresh --seed && php artisan storage:link"
