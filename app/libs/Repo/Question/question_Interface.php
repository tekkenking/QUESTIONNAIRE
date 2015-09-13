<?php namespace libs\Repo\Question;

Interface Question_Interface
{

	public function newQuestion();

	public function listAll();

	public function listAllActive();

	public function find($id);

	public function updateByID(Array $question, $id);

	public function toggleState($id, $currentState);

	public function destroy($ids);

	public function save_questions($inputs);

}