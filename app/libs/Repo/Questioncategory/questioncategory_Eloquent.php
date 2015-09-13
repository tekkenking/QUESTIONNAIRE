<?php namespace libs\Repo\Questioncategory;

use Questionnairecategory as Model;
use Questionnairesubcategory as Qsubcat;

class Questioncategory_Eloquent implements Questioncategory_Interface
{
	public function newModel()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::select('id', 'name', 'active')->get();
	}

	public function find($id)
	{
		return Model::where('id', '=', $id)->first();
	}

	public function findName($id)
	{
		return $this->find($id)->name;
	}

	public function getChildren($id)
	{
		$children = Model::find($id)
					->questionnairesubcategories()
					->select('id', 'name')
					->get();

		return ($children === null) ? [] : $children->toArray();

		//tt($children->toArray());
	}

	public function listAllWithSubCategory()
	{
		return Model::with([
			'questionnairesubcategories'=> function($q)
				{
					$q->with(['questions'=>function($qq){
						$qq->select('id', 'questionnairesubcategories_id');
					}])
					->select('id', 'questionnairecategories_id', 'name', 'active');
				}
			])
		->select('id', 'name', 'active')
		->get();
	}

	public function listAllWithQuestions()
	{
		$mode = Model::with(['questionnairesubcategories' => function($qc){
					$qc->with(['questions' => function($q){
						$q->with([

							'subquestions' => function($qr){
								$qr->with(['answers' => function($qrs){
									$qrs->with(['options'=>function($opx){
										$opx->select('id', 'alias', 'name');
									}])
									->select('id', 'question_id', 'sub_question_id', 'option_id', 'answer_type');
								}])->select('id', 'question_id', 'label', 'sub_question', 'active');
							},

							'answers'	=> function($qa){
								$qa->with(['options'=>function($opp){
									$opp->select('id', 'alias', 'name');
								}])
								->select('id', 'question_id', 'option_id', 'answer_type')
								->where('sub_question_id', '=', null);
							}

						])->select('id', 'questionnairecategories_id', 'questionnairesubcategories_id', 'label', 'question', 'has_sub_question', 'active');
					
					}])->select('id', 'name', 'questionnairecategories_id');
				}])
				->select('id', 'name', 'active')
				->get();

		return $mode;

		//tt($mode->toArray());
	}

	public function destroy($id)
	{
		$allSubcatid = Model::find($id)->questionnairesubcategories()->pluck('id');

			if( $allSubcatid !== null ){
				Qsubcat::destroy( $allSubcatid );
			}

		return Model::destroy($id);
	}
}