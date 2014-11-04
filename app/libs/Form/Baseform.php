<?php namespace libs\Form;

use libs\Validates\validateMe as validateme;

use Illuminate\Support\Facades\Input as Input;

class Baseform extends validateme
{

	protected $model;

	protected $allinputs;

	public function process()
	{

		$this->allinputs = Input::all();

		//Lets Validate
		if( ! $this->makeValidate() ){
			return false;
		}

		$this->beforeSave();

		//Lets check if it's to save or update
		return $this->save();
	}

	private function makeValidate(){

		//tt($this->model->rules);

		return $this->isValid( $this->model->rules );

		//tt($rules);

		//if( !isset($rules) ){
		//	return false;
		//}

		//tt($this->model->rules);

		//return $this->model->isValid();

		//return $this->branch->validateCreate(
		//	$this->model,
		//	$rules['rules'], 
		//	$rules['messages']
		//);
	}

	protected function beforeSave($options = null){}

	private function create(){
		return $this->model->savex();
	}

	private function update(){
		return $this->model->update( $this->allinputs );
	}

	public function save(){

		if( !isset($this->allinputs['id']) ){
			return $this->create();
		}else{
			return $this->update($this->allinputs);
		}
	}

	public function errors(){
		return $this->validate_errors();
	}

}