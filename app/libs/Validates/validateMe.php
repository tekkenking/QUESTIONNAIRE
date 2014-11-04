<?php namespace libs\Validates;

use Input;
use Validator;

class validateMe {

	public $rules = [];

	private $inputRules = [];

	private $inputs;

	private function selectRules($rules){

		$inputs = Input::all(); //Gets all the Inputs
		unset($inputs['_token']); //Unset the token

		//tt($inputs);

		$this->rules = $rules;

		//We check if it's multiArray
		$type = $this->isRuleMultiArray();


		if( $type == false ){
			foreach ($inputs as $key => $value) {
				//tt($this->rules[$key]);
				if( isset( $this->rules[$key] ) ){
					$this->inputRules[$key] = $this->rules[$key];
					$this->inputs[$key] = $value;
				}
			}
		}else{
			foreach ($inputs as $key => $value) {
				if( isset($this->rules['rules'][$key]) )
				{
					$this->inputRules['rules'][$key] = $this->rules['rules'][$key];
					$this->inputs[$key] = $value;
				}
			}

			$this->inputRules['messages'] = isset($this->rules['messages']) 
			? $this->rules['messages'] 
			: array();
		}

		//tt( $this->inputRules );

		return $this->inputRules;
	}

	private function isRuleMultiArray(){
		return isset($this->rules['rules']);
	}

	protected function validate()
	{
		return $this->validator =  Validator::make( $this->inputs, $this->inputRules );
	}

	public function isValid($rules)
	{

		if( empty($rules) ){ return true; }

		$this->selectRules($rules);
		$this->validate();

		return $this->validator->passes();
	}

	public function validate_errors()
	{
		return $this->validator->messages()->all();
	}
}