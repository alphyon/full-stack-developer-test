# full-stack-developer-test

###Para Ejecutar el test se debe de tener instalado docker en
la pc y ejecutar el siguiente commando

`` docker-compose build  && docker-compose up -d
``

esto levanta cada instancia de los contenedores

Para ejecutar e instalar las dependecias del cada serivicio ejecutar el comando 

``docker-compose exec php composer install``

``docker-compose exec phplumen composer install``

``docker-compose exec phplumen2 composer install``


###Hacer la copia de las variables de entorno

Ejecutar el comando 

``docker-compose exec php cp .env.example .env``

``docker-compose exec phplumen cp .env.example .env``

``docker-compose exec phplumen2 cp  .env.example .env``

###Correr la migraciones 

ejecutar los comandos

``docker-compose exec php php artisan migrate``

``docker-compose exec phplumen php artisan migrate``

``docker-compose exec phplumen2 cp artisan migrate``

###Instalar passport

ejecutar las siguientes comandos

``docker-compose exec phplumen2 cp artisan passport:install ``



los accesos a los servicios son los siguientes:

``
http://localhost:8088 -- servicios manajeo de vehiculos
``

``
http://localhost:8089 -- servicios manajeo de cuentas
``

``
http://localhost:8087 -- login 
``

