<?php namespace libs\Form;

use libs\Validates\validateMe as validateme;

use Illuminate\Support\Facades\Input as Input;

class Form extends validateme
{

	protected $model;

	protected $allinputs;

	protected function assignInputs( $inputs = null )
	{
		$this->allinputs = ( $inputs === null || empty($inputs) ) 
							? Input::all() 
							: $inputs;
	}


	public function onlyProcess(Array $inputs = null, $doinputs = true)
	{
		if($doinputs !== false ){$this->assignInputs( $inputs );}

		return $this->extend();
	}

	public function onlyValidate(Array $inputs = null, $doinputs = true)
	{
		if($doinputs !== false ){$this->assignInputs( $inputs );}

		//Lets Validate
		if( ! $this->isValid( $this->model->rules ) ){
			return false;
		}

		return true;
	}


	public function save($doinputs = true)
	{
		if($doinputs !== false ){$this->assignInputs( $doinputs );}
		$this->extendBeforeSave();
		return $this->model->savex( $this->allinputs );
	}	

	public function update($id, $doinputs = true)
	{
		if($doinputs !== false ){$this->assignInputs( $doinputs );}

		$this->allinputs['id'] = $id;
		$this->extendBeforeUpdate();
		return $this->model->updatex( $this->allinputs );
	}


	public function processThenSave(Array $inputs = null)
	{
		$this->onlyProcess(null, true);

		//Lets Validate
		if( ! $this->onlyValidate(null, false) ){
			return false;
		}

		//Lets check if it's to save or update
		return $this->save(false);
	}	

	public function processThenUpdate($id, Array $inputs = null)
	{
		$this->onlyProcess(null, true);
		$this->uniqueUpdateID = $id;
		
		//Lets Validate
		if( ! $this->onlyValidate(null) ){
			return false;
		}

		//Lets check if it's to save or update
		return $this->update($id, false);
	}

	protected function extend($options = null){}
	protected function extendBeforeSave($options = null){}
	protected function extendBeforeUpdate($options = null){}

	public function errors(){
		return $this->validate_errors();
	}

}