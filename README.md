# Tournament App

----------

## Installation

    Copy the example env file and make the required configuration changes in the .env file

        cp .env.example .env

    Build & run docker-composer images (**Verify you have already shared volumes folders**)

        docker-compose up

    Install all the dependencies using composer

        docker exec app composer install

    Generate a new application key

        docker exec app php artisan key:generate

    Run the database migration (**Set the database connection in .env before migrating**)

        docker exec app php artisan migrate


## Postman Collection 

https://drive.google.com/file/d/1mEjc6Byj6NJZN2vC4fvy2SioanoWIFYW/view?usp=sharing

