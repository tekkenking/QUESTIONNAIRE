<?php

class ServerController extends ApiBaseController {

	public function isServerFound()
	{
		$data['response'] = ['status' => 'found'];
		return Response::json($data)->setCallback(Input::get('callback'));
	}

}