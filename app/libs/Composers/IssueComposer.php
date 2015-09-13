<?php

/**
* 
*/

use libs\Repo\Issue\Issue_Eloquent as Issue;

class IssueComposer
{
	public $issue;

	public function __construct( Issue $issue )
	{
		$this->issue = $issue;
	}

	public function compose($view)
	{
		$issueCounter = $this->issue->counter();
		$view->with('issueCounterComposer', $issueCounter);
	}
}