<?php namespace libs\Validates;

use Input;
use Validator;

class validateMe {

	public $rules = [];
	private $inputRules = [];
	private $inputs;
	public $uniqueUpdateID = NULL;

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
					$this->inputRules['rules'][$key] = $this->isUniqueUpdate($this->rules['rules'][$key]);
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

	private function isUniqueUpdate($value){
		//tt($this->uniqueUpdateID);
		$searchword = 'unique';
		if( $this->uniqueUpdateID !== NULL ){
			//First checking if the value is array or string
			if( is_array($value) ){
				//Then we check the field to work on update id
				if( ! empty( $found = preg_grep("/$searchword/", $value) )){
					$arrKey = key($found);
					$new = str_replace('{ignore_id}', $this->uniqueUpdateID, $found[$arrKey]);
					$value[$arrKey] = $new;
					return $value;
				}else{
					return $value;
				}
			}else{
				//Lets first confirm if we can find the word Unique
				if(strpos($value, $searchword) === FALSE){
					return $value;
				}else{
					return str_replace('{ignore_id}', $this->uniqueUpdateID, $value);
				}
			}

		}else{
			return $value;
		}
	}

	private function isRuleMultiArray(){
		return isset($this->rules['rules']);
	}

	protected function validate()
	{
		$rules = isset($this->inputRules['rules']) ? $this->inputRules['rules'] : $this->inputRules;

		$messages = isset($this->inputRules['messages']) ? $this->inputRules['messages'] : [];

		return $this->validator =  Validator::make( $this->inputs, $rules, $messages );
	}

	public function isValid($rules)
	{

		if( empty($rules) ){ return true; }

		//This would let the class knw it's updatetype validation
		//$this->uniqueUpdateID = $id;

		$this->selectRules($rules);
		$this->validate();

		return $this->validator->passes();
	}

	public function validate_errors()
	{
		return $this->validator->messages()->all();
	}
}