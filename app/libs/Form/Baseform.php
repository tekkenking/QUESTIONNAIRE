<?php namespace libs\Form;

use libs\Validates\validateMe as validateme;

use Illuminate\Support\Facades\Input as Input;

class Baseform extends validateme
{

	protected $model;

	protected $allinputs;

	protected function assignInputs( $inputs = null )
	{
		$this->allinputs = ( $inputs === null || empty($inputs) ) 
							? Input::all() 
							: $inputs;
	}

	public function process()
	{
		$this->assignInputs();

		//Lets Validate
		if( ! $this->makeValidate() ){
			return false;
		}

		$this->beforeSave();

		//Lets check if it's to save or update
		return $this->save();
	}

	public function onlyProcess(Array $inputs = null)
	{
		$this->assignInputs( $inputs );

		return $this->beforeSave();
	}

	public function onlyValidate(Array $inputs = null)
	{
		$this->assignInputs( $inputs );

		//Lets Validate
		if( ! $this->makeValidate() ){
			return false;
		}

		return true;
	}

	private function save(){
		//tt($this->allinputs);
		if( isset($this->allinputs['id']) ){
			return $this->update();
		}else{
			return $this->create();
		}
	}

	public function onlySave(Array $inputs = null)
	{
		$this->assignInputs( $inputs );

		//Lets to save
		return $this->create();
	}

	public function onlyUpdate( $question_id, Array $inputs=null )
	{
		//tt($inputs);
		Input::merge(['id'=>$question_id]);
		$this->allinputs = Input::all();
		return $this->update();
	}

	private function makeValidate()
	{
		return $this->isValid( $this->model->rules );
	}

	protected function beforeSave($options = null){}

	private function create()
	{
		//tt($this->allinputs);
		return $this->model->savex( $this->allinputs );
	}

	protected function update(){
		return $this->model->updatex( $this->allinputs );
	}

	/*public function save(){

		if( !isset($this->allinputs['id']) ){
			return $this->create();
		}else{
			return $this->update($this->allinputs);
		}
	}*/

	public function errors(){
		return $this->validate_errors();
	}

}