<?php namespace libs\Repo\Subquestion;

use Subquestion as Model;

class Subquestion_Eloquent implements Subquestion_Interface
{
	public function newSubquestion()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::all();
	}

	public function find($id)
	{
		return Model::find($id);
	}

	public function findIDsByQuestionID($question_id)
	{
		return Model::where('question_id', '=', $question_id)->lists('id');
	}

	public function destroy($ids)
	{
		return Model::destroy($ids);
	}

	public function save_subquestions($inputs)
	{
		return Model::create($inputs);
	}
}