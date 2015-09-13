<?php namespace libs\Repo\Branch;

Interface Branch_Interface
{

	public function newbranch();

	public function listAll();

	public function listAllForSearchRecord();

	public function listAllActive();

	public function find($id);

	public function name($id);

	public function rank($id);

	public function updateRank($id, $rank);

	public function toggleState($id, $currentState);

	public function destroy($ids);

}