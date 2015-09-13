<?php namespace libs\Repo\Branch;

use Branch as Model;

class Branch_Eloquent implements Branch_Interface
{

	public function newbranch()
	{
		return new Model;
	}

	public function listAll()
	{
		return Model::orderBy('rank', 'desc')->get();
	}

	public function listAllForSearchRecord()
	{
		return Model::lists('name', 'id');
	}

	public function listAllActive()
	{
		return Model::where('active', '=', '1')
				->select('id', 'name', 'token')
				->get()
				->toArray();
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

	public function rank($id)
	{
		return Model::where('id', $id)
					->pluck('rank');
	}

	public function updateRank($id, $rank)
	{
		return Model::where('id', $id)->update(['rank'=>$rank]);
	}

	public function toggleState($id, $currentState)
	{
		return Model::find($id)->update(array('active' => $currentState));
	}

	public function destroy($ids)
	{
		return Model::destroy($ids);
	}

}

