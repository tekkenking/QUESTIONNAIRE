<?php

class Answer extends \Basemodel {
	protected $fillable = [];
	protected $softDelete = true;

	public function subquestions()
	{
		return $this->belongsTo('Subquestion');
	}

	public function questions()
	{
		return $this->belongsTo('Question');
	}	

	public function options()
	{
		return $this->belongsTo('Option', 'option_id');
	}
}