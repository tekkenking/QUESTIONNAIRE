<?php

class ServerController extends \BaseController {

	public function isServerFound()
	{
		$data['response'] = ['status' => 'found'];
		return Response::json($data)->setCallback(Input::get('callback'));
	}

}