<?php

use libs\Repo\Staff\Staff_Eloquent as Staff;
use libs\Repo\Record\Record_Eloquent as Record;
use libs\Repo\Staff\Form\Staff_form as Form;

class StaffsController extends \SecureBaseController {

	public function __construct(Staff $staff, Form $form, Record $record)
	{
		parent::__construct();

		$this->staff = $staff;
		$this->form = $form;
		$this->record = $record;
	}
	/**
	 * Display a listing of the resource.
	 * GET /staffs
	 *
	 * @return Response
	 */
	public function index()
	{
  	 	$js = [
				'smart,js,plugin,datatables' => [
					'jquery.dataTables'			=>	'jquery.dataTables.min.js',
					'dataTables.colVis'			=>	'dataTables.colVis.min.js',
					'dataTables.tableTools'		=>	'dataTables.tableTools.min.js',
					'dataTables.bootstrap'		=>	'dataTables.bootstrap.min.js'
				],

				'smart,js,notification'		=> [
					'smartnotification'			=>	'SmartNotification.min.js',
				],

				'bucketcodes,js' 			=> [
					'ajax-request-lite'			=>	'ajax-request-lite.js',
					'deleteitemx'				=>	'deleteitemx.js',
					'ajax-refresh'				=>	'ajax-refresh.js'
				],

				'tagmanager'				=> [
					'tagmanager'				=>	'tagmanager.js'
				]
		];

		$css = [
				'tagmanager'				=> [
					'tagmanager'				=>	'tagmanager.css'
				]
		];

		Larasset::start('footer')
				->storejs($js)
				->js('jquery.dataTables', 'dataTables.colVis', 'dataTables.tableTools', 'dataTables.bootstrap', 'ajax-request-lite', 'smartnotification', 'deleteitemx', 'ajax-refresh', 'tagmanager');

		Larasset::start('header')
				->storecss($css)
				->css('tagmanager');


		$data['staffs'] = $this->staff->listAll();


		$this->layout->title = 'Manage Staff';
		$this->layout->content = View::make('staffs.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /staffs/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('staffs.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /staffs
	 *
	 * @return Response
	 */
	public function store()
	{
		$status = $this->form->onlyValidate();

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$staffArr = $this->form->onlyProcess();

			foreach ($staffArr as $staff) {
				$this->form->onlySave($staff);
			}

			$data = Ajaxalert::success('Saved!')->url(URL::route('staffs.index'))->get();
		}

		return Response::json($data);
	}

	/**
	 * Display the specified resource.
	 * GET /staffs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /staffs/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$staff['staff'] = $this->staff->find($id);
		return View::make('staffs.edit', $staff);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /staffs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$status = $this->form->onlyValidate();

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$this->form->onlyUpdate($id);
			$data = Ajaxalert::success('Updated!')->url(URL::route('staffs.index'))->get();
		}

		return Response::json($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /branches/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($ids)
	{
		$status = $this->staff->destroy($ids);
		return Response::json(Ajaxalert::success('Deleted Successfully')->url(URL::route('staffs.index'))->get());
	}

	public function delete()
	{
		return $this->destroy( explode(',', Input::get('javascriptArrayString')) );
	}

	public function toggleState($id)
	{
		$newState = ( Input::get("state") == 1 ) ? 0 : 1;
		$statemessage = ( $newState == 1 ) ? 'Active' : 'Inactive';

		$status = $this->staff->toggleStateOrLock($id, 'active', $newState);

		if( $status ){
			$msg = Ajaxalert::arrayMessage([
				'id' 		=> $id,
				'stateint' 	=> $newState,
				'message'	=> $statemessage
				])->get();
		}else{
			$msg = Ajaxalert::error('Unknown error occured')->get();
		}

		return Response::json($msg);
	}

	public function toggleLock($id)
	{
		$newState = ( Input::get("lock") == 1 ) ? 0 : 1;
		$statemessage = ( $newState == 1 ) ? 'fa-unlock' : 'fa-lock';

		$status = $this->staff->toggleStateOrLock($id, 'lock', $newState);

		if( $status ){
			$msg = Ajaxalert::arrayMessage([
				'id' 		=> $id,
				'stateint' 	=> $newState,
				'message'	=> $statemessage
				])->get();
		}else{
			$msg = Ajaxalert::error('Unknown error occured')->get();
		}

		return Response::json($msg);
	}

}