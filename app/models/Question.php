<?php

class Question extends \Basemodel {
	protected $fillable = [];

	protected $softDelete = true;

	public function subquestions()
	{
		return $this->hasMany('Subquestion');
	}

	public function answers()
	{
		return $this->hasMany('Answer');
	}

	public function questionnairesubcategory()
	{
		return $this->belongsTo('Questionnairesubcategory', 'questionnairesubcategories_id');
	}	

	public function questionnairecategory()
	{
		return $this->belongsTo('Questionnairecategory', 'questionnairecategories_id');
	}

	public function records()
	{
		return $this->hasMany('Record');
	}
}