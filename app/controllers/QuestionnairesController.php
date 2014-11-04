<?php

use libs\Repo\Questionnaire\Questionnaire_Eloquent as Questionnaire;
use libs\Repo\Questionnaire\form\Questionnaire_form as Form;

class QuestionnairesController extends SecureBaseController {

	public function __construct(Questionnaire $questionnaire, Form $form)
	{
		parent::__construct();
		$this->questionnaire = $questionnaire;
		$this->form = $form;
	}

	/**
	 * Display a listing of the resource.
	 * GET /questionnaires
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
					'deleteitemx'				=>	'deleteitemx.js',
					'validater'					=>	'validater.js'
				]
		];

		Larasset::start('footer')
				->storejs($js)
				->js('jquery.dataTables', 'dataTables.colVis', 'dataTables.tableTools', 'dataTables.bootstrap', 'validater', 'ajax-request-lite', 'smartnotification', 'deleteitemx');


		$questionnaires['questionnaires'] = $this->questionnaire->listAll();

		///tt($questionnaires);

		$this->layout->title = 'Manage Questions';
		$this->layout->content = View::make('questionnaires.index', $questionnaires);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /questionnaires/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('questionnaires.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /questionnaires
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		//tt(Input::all());

		$status = $this->form->process();
		
	}

	/**
	 * Display the specified resource.
	 * GET /questionnaires/{id}
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
	 * GET /questionnaires/{id}/edit
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
	 * PUT /questionnaires/{id}
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
	 * DELETE /questionnaires/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}