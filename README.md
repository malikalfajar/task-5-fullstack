<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
    </a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things. 
## About the assignment

The Laravel framework provides many features for developers that aim to make it easier to build an application or website, one of which is the default engine from Laravel, namely the Blade Template. By using this engine, developers can easily create dynamic displays. By using the Blade Template we can also call other view pages to the main page easily. Laravel also provides API services to assist in connecting the program with databases on Investree

## Installation

### Dependencies preparation
    - composer install
    - composer update
    - cp .env.example .env
    - cp .env.testing.example .env.testing

### Storage Link
    - php artisan storage:link

### Change The Database Config
    Change Database configuration in .env and .env.testing 

### Generate and Run Migration
    - php artisan key:generate
    - php artisan migrate --seed
    - php artisan passport:install

### Frontend Preparation
    - npm install
    - npm run dev

### Run The Test and then run The Development Server
    - php artisan test
    - php artisan serve
# task-5-fullstack
