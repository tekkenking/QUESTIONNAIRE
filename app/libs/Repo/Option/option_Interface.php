<?php namespace libs\Repo\Option;

Interface Option_Interface
{

	public function newModel();

	public function listAll();

	public function find($id);

	public function destroy($id);
}