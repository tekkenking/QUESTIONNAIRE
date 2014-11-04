<?php namespace libs\Ajaxalert\ajaxalertFacade;

use Illuminate\Support\Facades\Facade;

class Ajaxalert extends Facade{

	protected static function getFacadeAccessor(){
		return 'ajaxalert';
	}
}