<?php namespace libs\Repo\Offeredanswer;

use Offeredanswer as Model;

class Offeredanswer_Eloquent implements Offeredanswer_Interface
{
	public function newOfferedanswer()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::all();
	}

	public function find($id)
	{
		return Model::find($id);
	}

	public function destroy($ids)
	{
		return Model::destroy($ids);
	}

	public function save_offeredanswers($inputs)
	{
		return Model::create($inputs);
	}
}