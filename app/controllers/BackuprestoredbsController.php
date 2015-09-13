<?php

class BackuprestoredbsController extends \SecureBaseController {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 * GET /backuprestoredbs
	 *
	 * @return Response
	 */
	public function index()
	{
		$js = [
				
				'vakata-jstree,dist'		=>	[
					'jstree'				=>	'jstree.min.js'
				]

		];

		$css = [
				
			   'vakata-jstree,dist,themes,default'		=>	[
					'jstree'				=>	'style.min.css'
				]
		];

		Larasset::start('footer')->storeJs($js)->js('jstree');
		Larasset::start('header')->storeCss($css)->css('jstree');

		$this->layout->title = "Backup & Restor DB";
		$this->layout->content = View::make('backuprestoredbs.index');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /backuprestoredbs/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /backuprestoredbs
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /backuprestoredbs/{id}
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
	 * GET /backuprestoredbs/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /backuprestoredbs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /backuprestoredbs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}