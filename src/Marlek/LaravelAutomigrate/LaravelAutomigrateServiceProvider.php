<?php namespace Marlek\LaravelAutomigrate;

use Marlek\LaravelAutomigrate\Commands\AutomigrateCommand;
use Marlek\LaravelAutomigrate\CommandGenerator;

use Illuminate\Support\ServiceProvider;

class LaravelAutomigrateServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('laravel-automigrate.php')
            ]);
        }
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['automigrate'] = $this->app->share(function($app)
        {
        	$config = $app['config']->get('laravel-automigrate');
        	$commandGenerator = new CommandGenerator();
        	$commandGenerator->setConfig($config);
            return new AutomigrateCommand($commandGenerator);
        });

        $this->commands('automigrate');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
