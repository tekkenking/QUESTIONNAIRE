<?php

class Issue extends Basemodel {
	protected $fillable = [];

	protected $guarded = ['id'];

	public function record()
	{
		return $this->belongsTo('Record');
	}
}