<?php

class Branch extends \Basemodel {
	protected $fillable = [];

 	public $rules = [
 		'rules' => [
			 		'name'	=> ['required', 'unique:branches,name,{ignore_id},id,deleted_at,NULL']
		],
 	];

 	public function records()
 	{
 		return $this->hasMany('Record', 'branch_id');
 	}
}