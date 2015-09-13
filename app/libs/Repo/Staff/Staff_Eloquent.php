<?php namespace libs\Repo\Staff;

use Staff as Model;

class Staff_Eloquent implements Staff_Interface{


	public function newModel()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::all();
	}

	public function listAllForSearchRecord()
	{
		return Model::lists('name', 'id');
	}

	public function find($id)
	{
		return Model::find($id);
	}

	public function name($id)
	{
		$name = $this->find($id)->name;
		return $name;
	}

	public function checkToken($token)
	{
		//tt($token);
		$status = Model::where('token','=', $token)->select('id', 'name')->get();
		return $status->toArray();
	}

	public function toggleStateOrLock($id, $field, $currentState)
	{
		return Model::find($id)->update(array($field => $currentState));
	}

	public function destroy($ids)
	{
		return Model::destroy($ids);
	}

}