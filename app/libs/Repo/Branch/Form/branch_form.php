<?php namespace libs\Repo\branch\form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Branch\Branch_Eloquent as Branch;

class Branch_form extends Baseform
{
	public function __construct( Branch $branch)
	{
		$this->branch = $branch;
		$this->model = $this->branch->newbranch();
	}

}