<?php

class Branch extends \Basemodel {
	protected $fillable = [];

 	protected $softDelete = true;

 	public $rules = [
 		'name'	=> 'required'
 	];

	/*public $set_rules = array(
			'rules'		=> array(
					'name'	=>	"required"
				),
			'messages'	=> array()
		);*/
}