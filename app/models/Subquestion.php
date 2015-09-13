<?php

class Subquestion extends \Basemodel {
	protected $fillable = [];
	protected $softDelete = true;
	protected $table = 'sub_questions';

	public function questions()
	{
		return $this->belongsTo('Question');
	}

	public function answers()
	{
		return $this->hasMany('Answer', 'sub_question_id');
	}
}