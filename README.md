# Laravel Automigrate

[![Build Status](https://travis-ci.org/marlek/laravel-automigrate.png?branch=master)](https://travis-ci.org/marlek/laravel-automigrate)

laravel-automigrate package allows you to define a sequence of migrations for
your vendor and workbench packages and run them with one command.


## Installing

Add the package to the list of required packages in composer.json file in the
root of your Laravel application.


    "require-dev": {
        "marlek/laravel-automigrate": "1.1.*"
    }


Then update Composer from the Terminal:


    composer update --dev


When the update completes, open your `app/config/app.php` file and add this item
to the array of providers:


    'Marlek\LaravelAutomigrate\LaravelAutomigrateServiceProvider'


Finally you can run `artisan` command in the root of you application and see
`automigrate` in the list of artisan commands


    php artisan


## Using

You need to define the list of migrations you want to run in the configuration
of the package. To do this, you first need to publish the configuration:


    php artisan config:publish marlek/laravel-automigrate


Then you need to open `app/config/packages/marlek/laravel-automigrate/config.php`
file and pass `packages` array like this:


    <?php
        return array(
            'packages' => array(
                array('package', 'marlek/some-package'),
                array('package', 'marlek/example-package'),
                array('bench', 'marlek/another-example'),
                array('path', 'path/to/migrations_folder'),
            )
        );


`package` key means that your package is in vendor directory (third-party package),
`bench` key means it's a package in you workbench directory,
and a `path` key means it's a directory containing your migrations.

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
