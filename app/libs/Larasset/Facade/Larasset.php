<?php namespace libs\Larasset\larassetFacade;

use Illuminate\Support\Facades\Facade;

class Larasset extends Facade{

	protected static function getFacadeAccessor(){
		return 'larasset';
	}
}