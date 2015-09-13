<?php

use libs\Repo\Branch\Branch_Eloquent as Branch;
use libs\Repo\Question\Question_Eloquent as Question;
use libs\Repo\API\Form\ApiForm as Form;
use libs\Repo\Staff\Staff_Eloquent as Staff;

class ApiController extends ApiBaseController{

	private $branch;
	private $question;
	private $form;

	public function __construct(Branch $branch, Question $question, Form $form, Staff $staff){
		$this->branch = $branch;
		$this->question = $question;
		$this->form = $form;
		$this->staff = $staff;
	}

	public function index()
	{
		$data['response'] = ['status' => 'Welcome to API INDEX PAGE'];
		return Response::json($data)->setCallback(Input::get('callback'));
	}

	public function updateAppInfo(){
		//First we fetch available and active Branches
		$data['branches'] = $this->branch->listAllActive();

		//List all Questions 
		$data['questions'] = $this->question->listAllActive();

		return Response::json($data)->setCallback(Input::get('callback'));
	}

	public function saveAppData(){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST');
		header('Access-Control-Max-Age: 1000');
		
		//tt(Input::all());
		$result = $this->form->process();

		if( $result === false ){
			$status['status'] = 'danger';
			$status['message'] = $this->form->errorMsg;
		}else{
			$status['status'] = 'success';
			$status['message'] = 'Completed upload!';
		}

		return Response::json($status);
	}

	public function authStaffToken()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST');
		header('Access-Control-Max-Age: 1000');
		//tt('shhdj');

		$result = $this->form->authStaffToken();

		if( $result ){
			$status['status'] = 'success';
			$status['message'] = 'Staff token authentication successful';
			$status['result'] = $this->staff->checkToken(Input::get('stafftoken'));
		}else{
			$status['status'] = 'danger';
			$status['message'] = 'Staff token authentication failed';	
		}

		return Response::json($status);

	}
}