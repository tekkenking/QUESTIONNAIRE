<?php namespace libs\Repo\Branch;

Interface Branch_Interface
{

	public function newbranch();

	public function listAll();

	public function find($id);

	public function destroy($ids);

}