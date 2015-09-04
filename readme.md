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
* Create the database you just used in .env
* Put in `php artisan migrate:refresh --seed`
* Put in `vendor/bin/phpunit tests/` and make sure all tests are green
* Set up a site using apache or use PHP built-in web server by putting in `php artisan serve`
* If you are using phpbrew to switch to php5.4+ like me, make sure to add `+mysql +pdo` when you run `phpbrew install`

## API

* A GET to /v1/user/[:key] : retrieve user info by user id/name/email. Access token required.
* A POST to /v1/user : register a new user.
* A PUT to /v1/user/[:key] : update user info by user id/name/email. Access token required.
* A DELETE to /v1/user/[:key] : delete user by user id/name/email. Access token required.
***
* A POST to /login : user log in. Receive an access token. 
* A POST to /logout : user log out. Access token required.
***
* A GET to /v1/blog/[:id] : retrieve blog info by blog id. Access token required.
* A POST to /v1/blog : create a new blog. Access token required.
* A PUT to /v1/blog/[:id] : update blog info by blog id. Access token required.
* A DELETE to /v1/blog/[:id] : delete blog by blog id. Access token required.
