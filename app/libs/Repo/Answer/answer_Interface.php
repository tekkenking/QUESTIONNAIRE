<?php namespace libs\Repo\Answer;

Interface Answer_Interface
{
	public function newAnswer();

	public function listAll();

	public function find($id);

	public function findIDsByQuestionID($question_id);

	public function destroy($ids);

	public function save_answers($inputs);
}