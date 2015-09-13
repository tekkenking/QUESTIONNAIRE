<?php namespace libs\Repo\Issue;

Interface Issue_Interface
{

	public function newModel();

	public function saveModel(Array $data);

	public function findById($id);

	public function all($filters= NULL);

	public function counter();

	public function getAllQuestions();

	public function getAllStaffs();

	public function getAllBranches();

	public function getAllRecordsIDByQuestionID($id);

	public function resolve($id);

	public function fix($id);

	public function destroy($ids);
}