# Scaner

## Installation
- git clone https://github.com/polo195pl/scaner.git
- set up db connection in .env (root folder)
- set up your connection to rabbitmq in .env
- composer install
- php bin/console doctrine:migrations:migrate
- symfony server:start
- go to localhost:8080
Thats all

## Requiments
- PHP Socket Extension
- RabbitMQ
