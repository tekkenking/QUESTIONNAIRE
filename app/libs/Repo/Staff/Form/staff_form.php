<?php namespace libs\Repo\Staff\Form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Staff\Staff_Eloquent as Staff;
use Makehash;

class Staff_form extends Baseform
{
	public function __construct( Staff $staff)
	{
		$this->staff = $staff;
		$this->model = $this->staff->newModel();
	}

	public function beforeSave( $options = null )
	{
		return $this->loopTheNames();
	}

	public function loopTheNames()
	{
		$nameArr = explode(',', $this->allinputs['name']);

		$counter = 0;
		//$this->allinputs = [];
		foreach ($nameArr as $name) {
			$staffs[$counter]['name'] = $name;
			$staffs[$counter]['token'] = '1'. Makehash::random('numbers', 6);
			$counter++;
		}

		return $staffs;
	}

}