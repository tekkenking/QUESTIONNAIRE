<?php

use libs\Repo\Questioncategory\Questioncategory_Eloquent as Qcat;
use libs\Repo\Questioncategory\Form\Questioncategory_form as Form;
use libs\Repo\Questionsubcategory\Form\Questionsubcategory_form as Subform;

class QuestionnairecategoriesController extends \SecureBaseController 
{
	public function __construct(Qcat $qcat, Form $form, Subform $subform)
	{
		parent::__construct();

		$this->qcat = $qcat;
		$this->form = $form;
		$this->subform = $subform;
	}

	/**
	 * Display a listing of the resource.
	 * GET /questionnairecategories
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
				->js('jquery.dataTables', 'dataTables.bootstrap', 'freset', 'validater', 'ajax-request-lite', 'ajax-refresh', 'smartnotification', 'deleteitemx', 'tagmanager');

		Larasset::start('header')
				->storecss($css)
				->css('tagmanager');

		$qcategories['qcategories'] = $this->qcat->listAllWithSubCategory();

		//tt( $qcategories['qcategories']->toArray() );

		if(! Request::ajax()){
			$this->layout->title = 'Manage questions category';
			$this->layout->content = View::make('questionnairecategories.index', $qcategories);
		}else{
			return View::make('questionnairecategories.includes.cat_list', $qcategories);
		}

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /questionnairecategories/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('questionnairecategories.create');
	}

	public function getChildren($id)
	{
		$children = $this->qcat->getChildren($id);
		$data['subcategories'] = $children;
		$data['status'] = 'success';
		return Response::json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /questionnairecategories
	 *
	 * @return Response
	 */
	public function store()
	{
		$status = $this->form->onlyValidate();

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$disArr = $this->form->onlyProcess();

			foreach ($disArr as $dis) {
				$qcO = $this->form->onlySave($dis);
					$nosubcat['name'] = 'No sub-category';
					$nosubcat['questionnairecategories_id'] = $qcO->id;
				$this->subform->onlySave($nosubcat);
				//tt($qcO);
			}

			$data = Ajaxalert::success('<span class="text-bold">Saved!</span>')->get();
		}

		return Response::json($data);
	}

	/**
	 * Display the specified resource.
	 * GET /questionnairecategories/{id}
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
	 * GET /questionnairecategories/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$qcat['qcat'] = $this->qcat->find($id);

		//tt($qcat['qcat']->name);

		return View::make('questionnairecategories.edit', $qcat);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /questionnairecategories/{id}
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
			$data = Ajaxalert::success('Updated!')->url(URL::route('questionnairecategories.index'))->get();
		}

		return Response::json($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /questionnairecategories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$state = $this->qcat->destroy($id);
		$data['status'] = 'success';
		return Response::json($data);
	}

}