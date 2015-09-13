<?php namespace libs\Makehash;

use Illuminate\Support\ServiceProvider;
use App;

class MakehashServiceProvider extends ServiceProvider
{
	public function register(){

		App::bind('makehash', function(){
			return new \libs\Makehash\Makehash;
		});


		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function(){
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			$loader->alias('Makehash', 'libs\Makehash\Facade\Makehash');
		});

	}
}