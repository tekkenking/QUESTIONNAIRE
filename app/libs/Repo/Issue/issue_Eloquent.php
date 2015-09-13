<?php namespace libs\Repo\Issue;

use Record as Model;
use \StdClass as StdClass;

class Issue_Eloquent implements Issue_Interface
{
	public function newModel()
	{
		return new Model;
	}

	public function saveModel(Array $data)
	{
		$model = Model::create($data);
		return $model;
	}

	public function findById($id)
	{
		return Model::find($id);
	}

	public function all($filters= NULL)
	{
		$model = Model::with([

					'Question' => function ($qns){
						$qns->select('id', 'label', 'question');
					},

					'Branch'	=>	function($q){
						$q->select('id', 'name');
					},

					'Staff'		=> function($x){
						$x->select('id', 'name');
					}
				])
				->select( 'id', 'question_id', 'branch_id', 'staff_id', 'issue_state', 'issue_created_at', 'date', 'created_at', 'updated_at' );

		if( isset($filters['question_id']) && !empty($filters['question_id']) && $filters['question_id'] > 0){
			$model = $model->where('question_id', $filters['question_id']);
		}

		if( isset($filters['branch_id']) && !empty($filters['branch_id']) && $filters['branch_id'] > 0){
			$model = $model->where('branch_id', $filters['branch_id']);
		}

		if( isset($filters['staff_id']) && !empty($filters['staff_id']) && $filters['staff_id'] > 0){
			$model = $model->where('staff_id', $filters['staff_id']);
		}

		if( isset($filters['searchdate']) && !empty($filters['searchdate']) ){
			$dateRange = sqlDateRange($filters['searchdate']);
			$model = $model->whereBetween('issue_created_at', $dateRange);
		}


		$model = $model->where('issue_state', '!=', 'NULL' )
		->orderBy('issue_created_at', 'DESC')
		->get();

		return $model;
	}

	public function counter()
	{
		$model = Model::where('issue_state', 1 )
				->count();

		return $model;
	}

	public function getAllQuestions()
	{
		$model = Model::with([ 
					'Question' => function ($qns){
						$qns->select('id', 'label', 'question');
					}
				 ])
				->select('question_id')
				->where('issue_state', '!=', 'NULL' )
				->groupBy('question_id')
				->get();


		return $model;
	}

	public function getAllStaffs()
	{
		$model = Model::with([
					'Staff'		=> function($x){
						$x->select('id', 'name');
					}
				])->select('staff_id')
				->where('issue_state', '!=', 'NULL' )
				->groupBy('staff_id')
				->get();


		return $model;
	}

	public function getAllBranches()
	{
		$model = Model::with([
			'Branch'	=>	function($q){
				$q->select('id', 'name');
			}
		])->select('branch_id')
		->where('issue_state', '!=', 'NULL' )
		->groupBy('branch_id')
		->get();


		return $model;
	}

	public function getAllRecordsIDByQuestionID($id)
	{
		$model = Model::select('id', 'issue_created_at')
				->where('question_id', $id)
				->orderBy('issue_created_at', 'ASC')
				->get()
				->toArray();
		return $model;
	}

	/*
	* Accepts string
	*/
	public function resolve($id)
	{
		$model = Model::where('id', $id)->update(['issue_state' => 3]);
	}

	/*
	* Accepts string
	*/
	public function fix($id)
	{
		$model = Model::where('id', $id)->update(['issue_state' => 2]);
	}

	public function destroy($ids)
	{
		$model = $this->findById($id);
		$model->restore();
		return $model;
	}
}