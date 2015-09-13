<?php namespace libs\Repo\Answer;

use Answer as Model;

class Answer_Eloquent implements Answer_Interface
{
	public function newAnswer()
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

	public function save_answers($inputs)
	{
		return Model::create($inputs);
	}
}