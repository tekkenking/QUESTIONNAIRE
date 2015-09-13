<?php

class SecureBaseController extends \BaseController{

	public function __construct()
	{
		$this->beforeFilter('auth');
	}

	protected function setupLayout(){
		parent::setupLayout();
		$this->addedLayout();
	}

	public function logout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::route('session.show.login');
	}

	protected function addedLayout()
	{
		$this->layout->header = View::make('layouts.secure.header');
		$this->layout->sidepanel = View::make('layouts.secure.sidepanel');

		View::composer('layouts.secure.sidepanel', 'IssueComposer');
	}

}