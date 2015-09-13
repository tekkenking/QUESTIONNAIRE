<?php namespace libs\Repo\Subquestion;

Interface Subquestion_Interface
{
	public function newSubquestion();

	public function listAll();

	public function find($id);

	public function findIDsByQuestionID($question_id);

	public function destroy($ids);

	public function save_subquestions($inputs);
}