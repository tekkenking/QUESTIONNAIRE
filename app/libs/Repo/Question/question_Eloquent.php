<?php namespace libs\Repo\Question;

use Question as Model;
use Subquestion as Subquestion;

class Question_Eloquent implements Question_Interface
{

	public function newQuestion()
	{
		return new Model;
	}

	public function listAll()
	{

		return Model::with(array(
					'subquestions' => function($q){

						$q->with(['answers'=>function($qr){
							$qr->with(['options'=>function($opk){
									$opk->select('id', 'alias', 'name');
							}])
							->select('id', 'question_id', 'sub_question_id', 'option_id', 'answer_type');
						}])->select('id', 'question_id', 'label', 'sub_question', 'active');
					}
				))->select('id', 'label', 'question', 'has_sub_question', 'active')->get();
	}

	public function listAllActive(){
		$mode = Model::with([
			'subquestions' => function($q){

				$q->with(array('answers'=>function($qr){
					$qr->with(['options'=>function($opx){
						$opx->select('id', 'alias', 'name');
					}])
					->select('id', 'question_id', 'sub_question_id', 'option_id', 'answer_type');
				}))->select('id', 'question_id', 'label', 'sub_question', 'active');
			},

			'answers'	=> function($qa){
				$qa->with(['options'=>function($opr){
						$opr->select('id', 'alias', 'name');
					}])
				->select('id', 'question_id', 'option_id', 'answer_type')
				->where('sub_question_id', '=', null);
			}
		])	->where('active', '=', "1")
			->select('id', 'question', 'has_sub_question')
			//->take(5)
			->get();

		return $mode->toArray();

	}

	public function find($id)
	{
		$mode = Model::where('id', '=', $id)->with([
					'subquestions' => function($q){

						$q->with(['answers'=>function($qr){
							$qr->with(['options'=>function($op){
								$op->select('id', 'alias', 'name');
							}])
								->select('id', 'question_id', 'sub_question_id', 'option_id', 'answer_type');
						}])->select('id', 'question_id', 'label', 'sub_question', 'active');
					},

					'answers'	=> function($qa){
						$qa->with(['options'=>function($opx){
							$opx->select('id', 'alias', 'name');
						}])
						->select('id', 'question_id', 'option_id', 'answer_type')
						->where('sub_question_id', '=', null);
					}
				])->select('id', 'label', 'questionnairecategories_id', 'questionnairesubcategories_id', 'question', 'has_sub_question', 'active')->first();

		return $mode;
		/*return ( $mode->has_sub_question == "1" ) 
				? $mode 
				: $mode->load('answers');*/
	}

	public function hasSubquestion($id){
		$status = Model::where( 'id', '=', $id )->first()->has_sub_question;
		return ($status == 1 ) ? true : false;
	}

	public function updateByID(Array $question, $id){
		return Model::find($id)->update( $question );
	}

	public function toggleState($id, $currentState){
		return Model::find($id)->update(array('active' => $currentState));
	}

	public function destroy($ids)
	{
		return Model::destroy($ids);
	}

	public function save_questions($inputs)
	{
		return Model::create($inputs);
	}

}

