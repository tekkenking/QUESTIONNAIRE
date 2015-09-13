<?php

class Option extends \Basemodel {
	protected $fillable = [];

	public $rules = [
		'rules' => [
			 		'name'	=> ['required', 'unique:options,name,{ignore_id},id,deleted_at,NULL'],
 					'alias'	=> ['required', 'unique:options,alias,{ignore_id},id,deleted_at,NULL', 'numeric']
		],
		'messages' => [
			'name.required' => 'Question option can not be empty',
			'alias.required' => 'Option alias can not be empty'
		]
 	];

 	public function answers()
 	{
 		return $this->hasMany('Answer');
 	}
}