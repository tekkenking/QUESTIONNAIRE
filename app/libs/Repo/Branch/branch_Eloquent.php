<?php namespace libs\Repo\Branch;

use Branch as Branch;

class Branch_Eloquent implements Branch_Interface
{

	public function newbranch()
	{
		return new Branch;
	}

	public function listAll()
	{
		return Branch::all();
	}

	public function find($id)
	{
		return Branch::find($id);
	}

	public function destroy($ids)
	{
		return Branch::destroy($ids);
	}

}

