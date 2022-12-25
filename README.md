# Installation Guide For Lockhood App Repo

## Please follow below steps:
- Clone `git clone {repo}`
- Copy `.env.example` to `.env`
- Open local server and create a databse call `lockhood_app`
- Run `composer install`
- Run `npm install` 
- Run `php artisan key:generate`
- Run `npm run dev` 
- Run `php artisan migrate`
- Run `php artisan storage:link` 
- Run `php artisan serve` 
