<?php namespace Bucketcodes\Larabackupsqlite\Facades;

use Illuminate\Support\Facades\Facade;

class Larabackupsqlite extends Facade{

	protected static function getFacadeAccessor(){
		return 'larabackupsqlite';
	}
}