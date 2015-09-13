<?php namespace libs\Repo\Questioncategory;

Interface Questioncategory_Interface
{
	public function newModel();

	public function listAll();

	public function find($id);

	public function findName($id);

	public function getChildren($id);

	public function listAllWithSubCategory();

	public function listAllWithQuestions();

	public function destroy($id);
}