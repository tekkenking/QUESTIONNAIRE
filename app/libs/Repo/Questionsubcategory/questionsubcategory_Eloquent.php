<?php namespace libs\Repo\Questionsubcategory;

use Questionnairesubcategory as Model;

class Questionsubcategory_Eloquent implements Questionsubcategory_Interface
{
	public function newModel()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::all();
	}

	public function find($id)
	{
		return Model::where('id', '=', $id)->first();
	}

	public function destroy($id)
	{
		return Model::destroy($id);
	}
}