<?php

class Staff extends \Basemodel {

	protected $fillable = [];

 	public $rules = [
 		'name'	=> 'required'
 	];

 	public function records()
 	{
 		return $this->hasMany('Record');
 	}
}