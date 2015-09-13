<?php

class Record extends Basemodel {

	// Add your validation rules here
 	public $rules = [
 		'searchdate'	=> 'required'
 	];

	// Don't forget to fill this array
	protected $fillable = [];

	protected $guarded = ['id'];

	public function branch()
	{
		return $this->belongsTo('Branch');
	}

	public function staff()
	{
		return $this->belongsTo('Staff');
	}

	public function question()
	{
		return $this->belongsTo('Question');
	}

	public function issue()
	{
		return $this->hasOne('Issue');
	}

}