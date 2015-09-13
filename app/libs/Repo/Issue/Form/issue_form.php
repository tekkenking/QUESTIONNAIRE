<?php namespace libs\Repo\Issue\Form;

use libs\Form\Form as Form;
use libs\Repo\Issue\Issue_Eloquent as Model;

class Issue_form extends Form{

	public function __construct(Model $issue){
		$this->issue = $issue;
		$this->model = $this->issue->newModel();
	}

	protected function extendBeforeSave($options = null){
		$this->allinputs['record_id'] = $this->allinputs['target_id'];
		unset( $this->allinputs['target_id'] );
		unset( $this->allinputs['toggle'] );
	}

}