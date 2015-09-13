<?php

use libs\Repo\Question\Question_Eloquent as Question;
use libs\Repo\Answer\Answer_Eloquent as Answer;
use libs\Repo\Subquestion\Subquestion_Eloquent as subQuestion;
use libs\Repo\Questioncategory\Questioncategory_Eloquent as Qcat;
use libs\Repo\Option\Option_Eloquent as Option;
use libs\Repo\Question\form\Question_form as Form;

class QuestionnairesController extends SecureBaseController {

	public function __construct(Question $question, Form $form, subQuestion $subquestion, Answer $answer, Qcat $qcat, Option $option)
	{
		parent::__construct();
		$this->question = $question;
		$this->subquestion = $subquestion;
		$this->answer = $answer;
		$this->form = $form;
		$this->qcat = $qcat;
		$this->option = $option;
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


		//$questionnaires['questionnaires'] = $this->question->listAll();

		$questionnaires['categories'] = $this->qcat->listAllWithQuestions();

		//tt($questionnaires['categories']->toArray());

		if( ! Request::Ajax() ){
			$this->layout->title = 'Manage Questions';
			$this->layout->content = View::make('questionnaires.index', $questionnaires);
		}else{
			return View::make('questionnaires.includes.available_categories', $questionnaires);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /questionnaires/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//$qcats['qcats'] = $this->qcat->listAll();
		//return View::make('questionnaires.create', $qcats);
	}

	public function createByCategory($id)
	{
		$qcat['qcatname'] = $this->qcat->findName($id);
		$qcat['qcatid'] = $id;
		$qcat['qsubcats'] = $this->qcat->getChildren($id);
		$qcat['qoption_alias'] = $this->option->listAll();

		//tt($qcat['qoption_alias']->toArray());

		return View::make('questionnaires.create', $qcat);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /questionnaires
	 *
	 * @return Response
	 */
	public function store()
	{
		//tt(Input::all());

		$refinedInputs = $this->form->onlyProcess();

		//tt($refinedInputs);

		$status = $this->form->onlySave( $refinedInputs );

		if( $status ){
			$msg = Ajaxalert::success('Questionnaire Saved! Input another set')->get();
		}else{
			$msg = Ajaxalert::error('Unknown error occured')->get();
		}

		return Response::json($msg);
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
		$data['question'] = $this->question->find($id);

		$cat['currentqsubcatid'] = $data['question']->questionnairesubcategories_id;
		$cat['qcatid'] = $data['question']->questionnairecategories_id;
		$cat['qcatname'] = $this->qcat->findName($cat['qcatid']);
		$cat['qsubcats'] = $this->qcat->getChildren($cat['qcatid']);
		$data['qoption_alias'] = $this->option->listAll();

		//tt($data['question']->toArray());

		$view = ( $data['question']->has_sub_question == 0 )
					? 'edit_question'
					: 'edit_sub_question';
					
		return View::make('questionnaires.edit', $cat)
				->with('id', $id)
				->nest('editquestion', 'questionnaires.includes.'.$view, $data);

		//tt($this->question->find($id)->toArray());
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
		$refinedInputs = $this->form->onlyProcess();

		$status = $this->form->onlyUpdate( $id, $refinedInputs );

		if( $status ){
			$msg = Ajaxalert::success('Questionnaire Updated!')->get();
		}else{
			$msg = Ajaxalert::error('Unknown error occured')->get();
		}

		return Response::json($msg);

	}

	public function toggleState($id)
	{	

		$newState = ( Input::get("state") == 1 ) ? 0 : 1;
		$statemessage = ( $newState == 1 ) ? 'Active' : 'Inactive';

		$status = $this->question->toggleState($id, $newState);

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

	/**
	 * Remove the specified resource from storage.
	 * DELETE /questionnaires/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		tt($id);
	}

	public function delete()
	{

		$id = Input::get('javascriptArrayString');

		if( $this->question->hasSubquestion($id) ){

			//Lets Delete all the Sub_Question
			$subquestion_ids_array = $this->subquestion->findIDsByQuestionID($id);
			$this->subquestion->destroy( $subquestion_ids_array );
			
		}

		//Lets Delete all the question answers
		$answer_ids_array = $this->answer->findIDsByQuestionID($id);
		$this->answer->destroy( $answer_ids_array );

		$status = $this->question->destroy($id);

		if( $status ){
			$msg = Ajaxalert::success('Deleted successfully')->get();
		}else{
			$msg = Ajaxalert::error('Unknown error occured')->get();
		}

		return Response::json($msg);

	}

}