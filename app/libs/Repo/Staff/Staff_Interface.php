<?php namespace libs\Repo\Staff;

Interface Staff_Interface{

	public function newModel();

	public function listAll();

	public function listAllForSearchRecord();

	public function find($id);

	public function name($id);

	public function checkToken($token);

	public function toggleStateOrLock($id, $field, $currentState);

	public function destroy($ids);
}