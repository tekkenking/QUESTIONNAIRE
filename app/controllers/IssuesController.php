<?php

use libs\Repo\Issue\Issue_Eloquent as Issue;
use libs\Repo\Issue\Form\Issue_form as Form;


class IssuesController extends \SecureBaseController {

	protected $form;
	protected $issue;

	public function __construct(Form $form, Issue $issue)
	{
		parent::__construct();
		$this->form = $form;
		$this->issue = $issue;
	}

	/**
	 * Display a listing of the resource.
	 * GET /issues
	 *
	 * @return Response
	 */
	public function index()
	{


		$js = [
				
				'select2,3.5.2'		=>	[
					'select2'				=>	'select2.min.js'
				],

				'bootstrap-daterangepicker'	=> [
					'bootstrap-daterangepicker'	=> 'daterangepicker.js'
				]

		];

		$css = [
				
			   'bootstrap-daterangepicker'	=>	[
			   		'bootstrap-daterangepicker'	=> 'daterangepicker-bs3.css'
			   ]
		];

		Larasset::start('footer')->storeJs($js)->js('bootstrap-daterangepicker', 'select2');
		Larasset::start('header')->storeCss($css)->css('bootstrap-daterangepicker');

		$data['questions'] = $this->issue->getAllQuestions();
		$data['branches'] = $this->issue->getAllBranches();
		$data['staffs'] = $this->issue->getAllStaffs();
		$data['issues']	= $this->issue->all();

		$this->layout->title = "Issues log";
		$this->layout->content = View::make('issues.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /issues/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /issues
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /issues/{id}
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
	 * GET /issues/{id}/edit
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
	 * PUT /issues/{id}
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
	 * DELETE /issues/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function pinIssue()
	{
		if( Input::get('toggle') === 'add' ){
			$model = $this->form->save( Input::all() );
			$data = Ajaxalert::success('Issue logged successfully!')->get();
			$data['id'] = $model->id;
		}else{
			$model = $this->issue->destroy( Input::get('target_id') );
			$data = Ajaxalert::success('Issue log removed!')->get();
			$data['id'] = $model->record_id;
		}
		
		return Response::json($data);
	}

	public function search()
	{
		$filters = Input::all();
		$data['issues'] = $this->issue->all($filters);
		return View::make('issues.includes.searched_result', $data);
		//tt(Input::all());
	}

	public function resolve()
	{
		$id = Input::get('question_id');
		//Lets get the ID of all the concern records
		$records_id = $this->issue->getAllRecordsIDByQuestionID($id);

		//This is the total number found
		$total_records_found = count($records_id);

		//Lets pop the last Array
		$last_record_id = array_pop($records_id);
		$last_record_id = $last_record_id['id'];

		//tt($last_record_id);

		if( $total_records_found > 1 ){

			//Lets fixed the remaing records_id
			foreach ($records_id as $record) {
				$fixed_record_id[] = $record['id'];
				$this->issue->fix($record['id']);
			}

			$data['fixed_ids'] = $fixed_record_id;
		}

		$this->issue->resolve($last_record_id);
		$data['resolved_id'] = $last_record_id;
		$data['total_records_found'] = $total_records_found;

		return Response::json($data);

	}

}