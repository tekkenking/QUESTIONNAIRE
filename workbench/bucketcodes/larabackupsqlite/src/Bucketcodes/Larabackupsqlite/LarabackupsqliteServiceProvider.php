<?php namespace Bucketcodes\Larabackupsqlite;

use Illuminate\Support\ServiceProvider;

class LarabackupsqliteServiceProvider extends ServiceProvider {

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
		$this->package('bucketcodes/larabackupsqlite');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['larabackupsqlite'] = $this->app->share( function($app){
			return new Larabackupsqlite($app['config']);
		});


		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function(){
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			$loader->alias('Larabackupsqlite', 'Bucketcodes\Larabackupsqlite\Facades\Larabackupsqlite');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('larabackupsqlite');
	}

}
