<?php namespace libs\Repo\Questionsubcategory\Form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Questionsubcategory\Questionsubcategory_Eloquent as Model;

class Questionsubcategory_form extends Baseform{

	public function __construct(Model $qsubcat){
		$this->qsubcat = $qsubcat;
		$this->model = $this->qsubcat->newModel();
	}

	public function beforeSave( $options = null )
	{
		return $this->loopTheNames();
	}

	public function loopTheNames()
	{
		$nameArr = explode(',', $this->allinputs['questionsubcategory']);

		$counter = 0;
		//$this->allinputs = [];
		foreach ($nameArr as $name) {
			$dis[$counter]['name'] = $name;
			$dis[$counter]['questionnairecategories_id'] = $this->allinputs['questioncategory'];
			$counter++;
		}

		return $dis;
	}

	protected function update(){
		$name = $this->allinputs['questionsubcategory'];
		unset($this->allinputs['questionsubcategory']);

		$this->allinputs['name']= $name;

		return $this->model->updatex( $this->allinputs );
	}

}