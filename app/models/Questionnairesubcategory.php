<?php

class Questionnairesubcategory extends \Basemodel {
	protected $fillable = [];

	public $rules = [
 		'questioncategory'	=> 'required',
 		'questionsubcategory'	=> 'required'
 	];

	public function questionnairecategory()
	{
		return $this->belongsTo('Questionnairecategory', 'questionnairecategories_id');
	}

	public function questions()
	{
		return $this->hasMany('Question', 'questionnairesubcategories_id');
	}
}