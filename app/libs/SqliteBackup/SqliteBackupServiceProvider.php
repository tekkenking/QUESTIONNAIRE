<?php namespace libs\SqliteBackup;

use Illuminate\Support\ServiceProvider;
use App;

class SqliteBackupServiceProvider extends ServiceProvider
{
	public function register(){

		App::bind('sqlitebackup', function(){
			return new \libs\SqliteBackup\SqliteBackup;
		});


		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function(){
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			$loader->alias('SqliteBackup', 'libs\SqliteBackup\SqliteBackupFacade\SqliteBackup');
		});

	}
}