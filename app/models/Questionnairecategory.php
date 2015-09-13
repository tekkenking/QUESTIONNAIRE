<?php

class Questionnairecategory extends \Basemodel {
	protected $fillable = [];

	public $rules = [
 		'questioncategory'	=> 'required'
 	];

	public function questionnairesubcategories()
	{
		return $this->hasMany('Questionnairesubcategory', 'questionnairecategories_id');
	}

	public function questions()
	{
		return $this->hasMany('Question', 'questionnairecategories_id');
	}
}