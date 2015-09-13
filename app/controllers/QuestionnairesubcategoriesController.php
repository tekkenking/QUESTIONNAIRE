<?php

use libs\Repo\Questioncategory\Questioncategory_Eloquent as Qcat;
use libs\Repo\Questionsubcategory\Questionsubcategory_Eloquent as Qsubcat;
use libs\Repo\Questionsubcategory\Form\Questionsubcategory_form as Form;

class QuestionnairesubcategoriesController extends \SecureBaseController {

	public function __construct(Qcat $qcat, Qsubcat $qsubcat, Form $form)
	{
		parent::__construct();

		$this->qsubcat = $qsubcat;
		$this->qcat = $qcat;
		$this->form = $form;
	}

	/**
	 * Display a listing of the resource.
	 * GET /questionnairesubcategory
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /questionnairesubcategory/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$category['qcats'] = $this->qcat->listAll();

		return View::make('questionnairesubcategories.create', $category);
	}

	public function createForCategory($id)
	{
		$category['qcat_name'] = $this->qcat->findName($id);
		$category['qcat_id'] = $id;
		return View::make('questionnairesubcategories.create', $category);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /questionnairesubcategory
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$status = $this->form->onlyValidate();

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$disArr = $this->form->onlyProcess();

			foreach ($disArr as $dis) {
				$this->form->onlySave($dis);
			}

			$data = Ajaxalert::success('<span class="text-bold">Saved!</span>')
					->url(URL::route('questionnairecategories.index'))
					->get();
		}

		return Response::json($data);
	}

	/**
	 * Display the specified resource.
	 * GET /questionnairesubcategory/{id}
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
	 * GET /questionnairesubcategory/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$qsubcat['qsubcat'] = $this->qsubcat->find($id);
		return View::make('questionnairesubcategories.edit', $qsubcat);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /questionnairesubcategory/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$status = $this->form->onlyValidate();
		$status = $this->form->onlyUpdate($id);

		if( ! $status ){
			$data = Ajaxalert::error($this->form->errors())->get();
		}else{
			$data = Ajaxalert::success('Updated!')->url(URL::route('questionnairecategories.index'))->get();
		}

		return Response::json($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /questionnairesubcategory/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$state = $this->qsubcat->destroy($id);
		$data['status'] = 'success';
		return Response::json($data);
	}

}