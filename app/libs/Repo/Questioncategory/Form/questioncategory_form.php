<?php namespace libs\Repo\Questioncategory\Form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Questioncategory\Questioncategory_Eloquent as Model;

class Questioncategory_form extends Baseform{

	public function __construct(Model $qcat){
		$this->qcat = $qcat;
		$this->model = $this->qcat->newModel();
	}

	public function beforeSave( $options = null )
	{
		return $this->loopTheNames();
	}

	public function loopTheNames()
	{
		$nameArr = explode(',', $this->allinputs['questioncategory']);

		$counter = 0;
		//$this->allinputs = [];
		foreach ($nameArr as $name) {
			$dis[$counter]['name'] = $name;
			$counter++;
		}

		return $dis;
	}

	protected function update(){
		$name = $this->allinputs['questioncategory'];
		unset($this->allinputs['questioncategory']);

		$this->allinputs['name']= $name;

		return $this->model->updatex( $this->allinputs );
	}


}