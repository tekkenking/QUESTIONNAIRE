<?php namespace libs\Makehash\Facade;

use Illuminate\Support\Facades\Facade;

class Makehash extends Facade{

	protected static function getFacadeAccessor(){
		return 'makehash';
	}
}