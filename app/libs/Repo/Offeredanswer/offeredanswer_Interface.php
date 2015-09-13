<?php namespace libs\Repo\Offeredanswer;

Interface Offeredanswer_Interface
{
	public function newOfferedanswer();

	public function listAll();

	public function find($id);

	public function destroy($ids);

	public function save_offeredanswers($inputs);
}