<?php

use libs\Repo\Option\Option_Eloquent as Option;
use libs\Repo\Option\form\Option_form as Form;

class OptionsController extends \SecureBaseController {

	public function __construct(Option $option, Form $form)
	{
		parent::__construct();

		$this->option = $option;
		$this->form = $form;
	}

	/**
	 * Display a listing of the resource.
	 * GET /options
	 *
	 * @return Response
	 */
	public function index()
	{
  	 	$js = [
				'smart,js,plugin,datatables' => [
					'jquery.dataTables'			=>	'jquery.dataTables.min.js',
					'dataTables.bootstrap'		=>	'dataTables.bootstrap.min.js'
				],

				'smart,js,notification'		=> [
					'smartnotification'			=>	'SmartNotification.min.js',
				],

				'bucketcodes,js' 				 => [
					'ajax-refresh'				=>	'ajax-refresh.js',
					'ajax-request-lite'			=>	'ajax-request-lite.js',
					'deleteitemx'				=>	'deleteitemx.js',
					'validater'					=>	'validater.js',
					'freset'					=>	'freset.js'
				]
		];

		Larasset::start('footer')
				->storejs($js)
				->js('jquery.dataTables', 'dataTables.bootstrap', 'freset', 'validater', 'ajax-request-lite', 'ajax-refresh', 'smartnotification', 'deleteitemx');


		$options['options'] = $this->option->listAll();


		if(! Request::ajax()){
			$this->layout->title = 'Manage answers option';
			$this->layout->content = View::make('options.index', $options);
		}else{
			return View::make('options.includes.answers_list', $options);
		}
	}

	public function floatview()
	{
  	 	$js = [
				'smart,js,plugin,datatables' => [
					'jquery.dataTables'			=>	'jquery.dataTables.min.js',
					'dataTables.bootstrap'		=>	'dataTables.bootstrap.min.js'
				]
		];

		Larasset::start('footer')
				->storejs($js)
				->js('jquery.dataTables', 'dataTables.bootstrap');

		$options['options'] = $this->option->listAll();
		//tt($options['options']->toArray());
		return View::make('options.floatview', $options);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /options/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('options.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /options
	 *
	 * @return Response
	 */
	public function store()
	{
		$status = $this->form->processThenSave();

		if( ! $status )
		{
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$data = Ajaxalert::success('Rating scale created')->get();
		}

		return Response::json($data);
	}

	/**
	 * Display the specified resource.
	 * GET /options/{id}
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
	 * GET /options/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['option'] = $this->option->find($id);
		return View::make('options.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /options/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$status = $this->form->processThenUpdate($id);

		if( ! $status )
		{
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$data = Ajaxalert::success('Rating scale updated')->get();
		}

		return Response::json($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /options/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->option->destroy($id);
		$data['status'] = 'success';
		return Response::json($data);
	}

}