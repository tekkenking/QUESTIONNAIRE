<?php

class NonSecureBaseController extends \BaseController
{

	public function __construct()
	{
		$this->beforeFilter('guest');
	}
	
}