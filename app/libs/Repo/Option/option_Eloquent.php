<?php namespace libs\Repo\Option;

use Option as Model;

class Option_Eloquent implements Option_Interface
{

	public function newModel()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::select('id', 'name', 'alias', 'create_issue')
					->orderBy('alias')
					->get();
	}

	public function find($id)
	{
		return Model::where('id', '=', $id)
				->first();
	}

	public function destroy($ids)
	{
		return Model::destroy($ids);
	}

}