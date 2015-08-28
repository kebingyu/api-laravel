## A simple RESTful blog api 

* Built on top of Laravel 5 
* Using TDD

## Install

* git clone https://github.com/kebingyu/api-laravel.git <whatever name you like>
* Install composer and move composer.phar into /usr/bin/
* Go to the cloned folder
* Put in `composer install` to resolve denpendency
* Put in `cp .env.example .env`
* Put in `php artisan key:generate`
* Edit .env and put in database credential. If you have problem connecting to localhost, try to use `DB_HOST=127.0.0.1`
* Run config/db.sql in mysql
* Set up a site using apache or use PHP built-in web server by putting in `php artisan serve`
* If you are using phpbrew to switch to php5.4+ like me, make sure to add `+mysql +pdo` when you install by phpbrew.

## API

* A GET to /v1/user/<key> : retrieve user info by user primary key id/name/email.
* A POST to /v1/user : register a new user.
* A PUT to /v1/user/<key> : update user info by user primary key id/name/email.
* A DELETE to /v1/user/<key> : delete user by user primary key id/name/email.
