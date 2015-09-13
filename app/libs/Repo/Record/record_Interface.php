<?php namespace libs\Repo\Record;

Interface Record_Interface
{

	public function newModel();

	public function saveModel(Array $data);

	public function findById($id);

	public function paginate($model, $page, $take, $totalItems=0);

	public function getByBranch($type, $typeid, $daterange, $page, $take);

	public function fetchRecords($date, $staffID, $branchID);

	public function getByDate($type, $typeid, $daterange, $page, $take);

	public function all();

	public function destroyIssue($id);
}