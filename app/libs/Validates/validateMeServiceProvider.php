<?php namespace libs\Validates;

use Illuminate\Support\ServiceProvider;

class validateMeServiceProvider extends ServiceProvider
{
	public function register(){
		$this->app->bind(
			'libs\Validates\validateMe'
			);
	}
}