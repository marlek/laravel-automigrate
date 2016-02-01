# Laravel Automigrate

[![Build Status](https://travis-ci.org/marlek/laravel-automigrate.png?branch=master)](https://travis-ci.org/marlek/laravel-automigrate)

laravel-automigrate package allows you to define a sequence of migrations for
your vendor and workbench packages and run them with one command.


## Installing

Require the package with composer:


    composer require marlek/laravel-automigrate


When the installation completes, open your `app/config/app.php` file and add this item
to the array of providers:


    'Marlek\LaravelAutomigrate\LaravelAutomigrateServiceProvider'


Finally you can run `artisan` command in the root of you application and see
`automigrate` in the list of artisan commands


    php artisan


## Using

You need to define the list of migrations you want to run in the configuration
of the package. To do this, you first need to publish the configuration:


    php artisan vendor:publish


Then you need to open `app/config/laravel-automigrate.php`
file and pass `paths` array like this:


    <?php
        return [
            'paths' => [
                'path/to/migrations_folder_one',
                'path/to/migrations_folder_two'
            ]
        ];

Finally, the only thing left to do is run the command to migrate your database


    php artisan automigrate


### Reset previous migrations

If you want to reset previous migrations before running migrate again, just
pass the `reset` option


    php artisan automigrate --reset


### Seed the database

Just like `migrate` command, this command accepts `seed` option, in case you want
to seed your database after the migrations


    php artisan automigrate --seed

---

Reset and seed can be combined into a command which will reset your migrations,
run all migrations again and after that seed the database


    php artisan automigrate --seed --reset


Regular `migrate` command will be run after all package migrations

### Older versions of Laravel

If you're using Laravel 4.* you should use the package version 1.2:

    composer require marlek/laravel-automigrate:1.2
