<?php namespace libs\Repo\branch\form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Branch\Branch_Eloquent as Branch;
use Makehash;

class Branch_form extends Baseform
{
	public function __construct( Branch $branch)
	{
		$this->branch = $branch;
		$this->model = $this->branch->newbranch();
	}

	public function beforeSave( $options = null )
	{
		return $this->loopTheNames();
	}

	public function loopTheNames()
	{
		$nameArr = explode(',', $this->allinputs['name']);

		$counter = 0;
		
		foreach ($nameArr as $name) {
			$branches[$counter]['name'] = $name;
			$branches[$counter]['token'] = Makehash::random('numbers', 6);
			$counter++;
		}

		return $branches;
	}

}