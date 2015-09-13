<?php namespace libs\Repo\Questionsubcategory;

Interface Questionsubcategory_Interface
{
	public function newModel();

	public function listAll();

	public function find($id);

	public function destroy($id);
}