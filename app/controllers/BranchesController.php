<?php

use libs\Repo\Branch\Branch_Eloquent as Branch;

use libs\Repo\branch\form\Branch_form as Form;

class BranchesController extends \SecureBaseController {

	public function __construct(Branch $branch, Form $form)
	{
		parent::__construct();

		$this->branch = $branch;
		$this->form = $form;
	}

	/**
	 * Display a listing of the resource.
	 * GET /branches
	 *
	 * @return Response
	 */
	public function index()
	{

  	 	$js = [
				'smart.js.plugin.datatables' => [
					'jquery.dataTables'			=>	'jquery.dataTables.min.js',
					'dataTables.colVis'			=>	'dataTables.colVis.min.js',
					'dataTables.tableTools'		=>	'dataTables.tableTools.min.js',
					'dataTables.bootstrap'		=>	'dataTables.bootstrap.min.js'
				],

				'smart.js.notification'		=> [
					'smartnotification'			=>	'SmartNotification.min.js',
				],

				'bucketcodes.js' 				 => [
					'ajax-request-lite'			=>	'ajax-request-lite.js',
					'deleteitemx'				=>	'deleteitemx.js'
				]
		];

		Larasset::start('footer')
				->storejs($js)
				->js('jquery.dataTables', 'dataTables.colVis', 'dataTables.tableTools', 'dataTables.bootstrap', 'ajax-request-lite', 'smartnotification', 'deleteitemx');


		$branches['branches'] = $this->branch->listAll();

		//tt($branches);

		$this->layout->title = 'List Branches';
		$this->layout->content = View::make('branches.index', $branches);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /branches/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('branches.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /branches
	 *
	 * @return Response
	 */
	public function store()
	{

		$status = $this->form->process();

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$data = Ajaxalert::success('Saved!')->url(URL::route('branches.index'))->get();
		}

		return Response::json($data);
	}

	/**
	 * Display the specified resource.
	 * GET /branches/{id}
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
	 * GET /branches/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$branch['branch'] = $this->branch->find($id);
		return View::make('branches.edit', $branch);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /branches/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$status = $this->form->process();

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$data = Ajaxalert::success('Updated!')->url(URL::route('branches.index'))->get();
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
		$status = $this->branch->destroy($ids);
		return Response::json(Ajaxalert::success('Deleted Successfully')->url(URL::route('branches.index'))->get());
	}

	public function delete()
	{
		return $this->destroy( explode(',', Input::get('javascriptArrayString')) );
	}

}