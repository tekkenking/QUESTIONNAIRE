<?php namespace libs\Repo\Option\form;

use libs\Form\Form as Form;
use libs\Repo\Option\Option_Eloquent as Option;

class Option_form extends Form
{
	public function __construct( Option $option)
	{
		$this->option = $option;
		$this->model = $this->option->newModel();
	}

	public function extendBeforeUpdate($options = null){
		if( isset($this->allinputs['create_issue']) === False){
			$this->allinputs['create_issue'] = NULL;
		}

	}

}