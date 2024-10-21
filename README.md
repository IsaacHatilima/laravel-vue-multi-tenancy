## Laravel + Vue Multi Tenancy Starter project

This is a Laravel with Vue.js multi tenancy starter application.

- [Laravel](https://laravel.com).
- [Inertia](https://inertiajs.com/).
- [Vue Js](https://vuejs.org/).
- [Tenancy for Laravel](https://tenancyforlaravel.com/).

## Why?

Having a stater project with the essential basics can speed up development.This application is created with the laravel
command to create a new breeze application. After the initial project creation,
Two-Factor Authentication with [Laravel Fortify](https://laravel.com/docs/11.x/fortify) was also added for extra
security. Because the app is using Fortify for authentication, you can modify the login process in the
[FortifyServiceProvider.php](https://github.com/IsaacHatilima/laravel-vue-starter/blob/master/app/Providers/FortifyServiceProvider.php)
. A ModelHelper class to handle **public_id** was also added because we don't want to have our primary keys in the url.

## Tenancy for Laravel

The multi-tenancy is currently configured to subdomain identification and single database. Following the
docs [here](https://tenancyforlaravel.com/) you
can change to multi-database and any other type of identification you would like.

## Installation

To run the starter app locally, make the required changes to your **.env** file and run the following commands.

- ```composer install```
- ```php artisan key:generate```
- ```php artisan migrate```
- ```npm install```
- ```npm run dev```
- ```php artisan serve```


