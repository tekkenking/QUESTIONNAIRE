<?php namespace libs\Repo\API\Form;

use Input;
use libs\Repo\Record\Record_Eloquent as Record;
use libs\Repo\Staff\Staff_Eloquent as Staff;
use libs\Repo\Option\Option_Eloquent as Option;
use libs\Repo\Branch\Branch_Eloquent as Branch;

class ApiForm{

	public $leftBlank = 'Not answered';
	private $answerOpt = [];
	public $errorMsg = [];
	private $branch_rank = 0;

	public function __construct(Record $record, Staff $staff, Option $option, Branch $branch){
		$this->record = $record;
		$this->staff = $staff;
		$this->option = $option;
		$this->branch = $branch;
	}

	private function _getAnswerOptions()
	{
		$ans = $this->option->listAll();

		if( $ans !== null ){
			$optByID = [];
			foreach ($ans->toArray() as $key => $value) {
				$getID = $value['id'];
				$optByID[$getID] = $value;
			}

			$ans = $optByID;
		}

		return $ans;
	}

	private function _getBranchCurrentRank($id)
	{
		return $this->branch->rank($id);
	}

	public function process()
	{
		$arrData = Input::all();

		if( !isset( $arrData['endofline'] ) ){
			$this->setErrorMsg('Answer upload incomplete. Please re-upload');
			return false;
		}

		//tt($arrData);

		$staff = $arrData['staff'];
		unset($arrData['staff']);
		unset($arrData['endofline']);

		$counter = 0;
		$this->answerOpt = $this->_getAnswerOptions();

		//tt($this->answerOpt);

		foreach( $arrData as $branchID => $questionsArr ){

			//Lets get Branch Details
			$dt = explode('_', $branchID);
			$bnd = explode('-', $dt[0]);
			$branch_id = $bnd[3];

			$qdate = sqldate($dt[1]);
			$this->branch_rank = $this->_getBranchCurrentRank($branch_id);

			 foreach ($questionsArr['question'] as $question_id => $value) {
			 	$qns = [];
			 	$qns['staff_id'] = $staff['id'];
			 	
			 	$qns['branch_id'] = $branch_id;
			 	//$qns[$counter]['branch_id'] = $branch_id;
			 	$qns['date'] = $qdate;
			 	//$qns[$counter]['date'] = $qdate;
			 	$qns['question_id'] = $question_id;
			 	//$qns[$counter]['question_id'] = $question_id;

			 	//That means we have a subquestion
			 	if( isset($value['subquestion']) ){
			 		foreach ($value['subquestion'] as $sbk => $sb) {
			 			
			 			if( is_array($sb) ){

			 				if(strpos($sbk, ':::') !== FALSE){

			 					//We empty all the set array
				 				$value['subquestion'][$sbk] = [];
				 				foreach($sb as $dkey => $dvalue)
				 				{	
				 					//We start setting the newly refined version
				 					$value['subquestion'][$sbk][] = implode(':::', $dvalue);
				 				}
				 				continue;
				 			}else{
					 			foreach ($sb as $x => $y) {
					 				if( $y === '' ){
					 					//unset($value['subquestion'][$sbk][$x]);
					 					$value['subquestion'][$sbk][$x] = $this->leftBlank;
					 				}else{
					 					$value['subquestion'][$sbk][$x] = $this->_getAnswerOpt($y);
					 				}
					 			}

				 			}

				 		}else{
				 			$value['subquestion'][$sbk] = $this->_getAnswerOpt($sb);
				 		}

			 			if( empty($value['subquestion'][$sbk]) ){
			 				//tt($value['subquestion'][$sbk], true);
			 				//unset($value['subquestion'][$sbk]);
			 				$value['subquestion'][$sbk] = $this->leftBlank;
			 			}
				 		
			 		}

		 			if( empty($value['subquestion']) ){ continue; }
			 		$qns['subquestion'] = json_encode($value);
			 		//$qns[$counter]['subquestionx'] = $value;

			 	}else{

			 		if( is_array($value) ){
				 		foreach( $value as $k => $v){
				 			if( $v === '' ){
				 				//unset($value[$k]);
				 				$value[$k] = $this->leftBlank;
				 			}else{
				 				$value[$k] = $this->_getAnswerOpt($v);
				 			}
				 		}

				 		if( empty($value) ){
				 			continue;
				 		}
			 		}
			 		
			 		$value = $this->_getAnswerOpt($value, true);
			 		

			 		$qns['answer'] = $value;
			 		//$qns[$counter]['answer'] = $value;
			 	}
			 	//tt($qns, true);

			 	$this->record->saveModel($qns);
			 	
			 }
				//tt($this->branch_rank, true, 'Branch ID: ' . $branch_id . "\n Date: " . $qdate);
			 $this->_saveUpdateBranchRank($branch_id);
		}

		//tt($qns);

		return true;
	}

	private function _saveUpdateBranchRank($id)
	{
		$this->branch->updateRank($id, $this->branch_rank);
		$this->branch_rank = 0;
	}

	private function _getAnswerOpt($value, $json_encode=false)
	{
		if( ! is_array($value) ){

			if( isset($this->answerOpt[$value]) ){
				$r = $this->answerOpt[$value];
				//$this->branch_rank .= '+ ' . $r['alias'];
				$this->branch_rank += $r['alias'];
				$x = $r['name'];
			}else{
				$x = $value;
			}

		}else{
			$x = $value;
		}

		return ( $json_encode === false ) ? $x : json_encode($x);
	}

	public function authStaffToken()
	{
		$data = Input::all();

		//Lets Authenticate Token
		$status = $this->staff->checkToken($data);

		return ( empty($status) ) ? false : true;
	}

	protected function setErrorMsg($msg)
	{
		$this->errorMsg[] = $msg;
	}
}

/*

class ApiForm{

	public $leftBlank = 'Not answered';
	private $answerOpt = [];
	public $errorMsg = [];
	private $branch_rank = 0;

	public function __construct(Record $record, Staff $staff, Option $option, Branch $branch){
		$this->record = $record;
		$this->staff = $staff;
		$this->option = $option;
		$this->branch = $branch;
	}

	private function _getAnswerOptions()
	{
		$ans = $this->option->listAll();

		if( $ans !== null ){
			$optByID = [];
			foreach ($ans->toArray() as $key => $value) {
				$getID = $value['id'];
				$optByID[$getID] = $value;
			}

			$ans = $optByID;
		}

		return $ans;
	}

	private function _getBranchCurrentRank($id)
	{
		return $this->branch->rank($id);
	}

	public function process()
	{
		$arrData = Input::all();

		if( !isset( $arrData['endofline'] ) ){
			$this->setErrorMsg('Answer upload incomplete. Please re-upload');
			return false;
		}

		$staff = $arrData['staff'];
		unset($arrData['staff']);
		unset($arrData['endofline']);

		$counter = 0;
		$this->answerOpt = $this->_getAnswerOptions();

		//tt($this->answerOpt);

		$qns['staff_id'] = $staff['id'];
		$x = 0;
		foreach( $arrData as $branchID => $questionsArr ){

			//Lets get Branch Details
			$dt = explode('_', $branchID);
			$bnd = explode('-', $dt[0]);
			$branch_id = $bnd[3];

			$qdate = sqldate($dt[1]);
			$this->branch_rank = $this->_getBranchCurrentRank($branch_id);

			$x++;
		 	$qns['children'][$x]['branch_id'] = $branch_id;
		 	$qns['children'][$x]['date'] = $qdate;

		 	$q = 0;
			 foreach ($questionsArr['question'] as $question_id => $value) {
			 	$q++;
			 	$qns['children'][$x]['uploaded'][$q]['question_id'] = $question_id;
			 	//tt($qns);

			 	//That means we have a subquestion
			 	if( isset($value['subquestion']) ){
			 		foreach ($value['subquestion'] as $sbk => $sb) {
			 			
			 			if( is_array($sb) ){
				 			foreach ($sb as $xk => $y) {
				 				if( $y === '' ){
				 					//unset($value['subquestion'][$sbk][$x]);
				 					$value['subquestion'][$sbk][$xk] = $this->leftBlank;
				 				}else{
				 					$value['subquestion'][$sbk][$xk] = $this->_getAnswerOpt($y);
				 				}
				 			}
				 		}else{
				 			$value['subquestion'][$sbk] = $this->_getAnswerOpt($sb);
				 		}

			 			if( empty($value['subquestion'][$sbk]) ){
			 				//tt($value['subquestion'][$sbk], true);
			 				//unset($value['subquestion'][$sbk]);
			 				$value['subquestion'][$sbk] = $this->leftBlank;
			 			}
				 		
			 		}

		 			if( empty($value['subquestion']) ){ continue; }
			 		$qns['children'][$x]['uploaded'][$q]['subquestion'] = json_encode($value);
			 		//$qns[$counter]['subquestionx'] = $value;

			 	}else{

			 		if( is_array($value) ){
				 		foreach( $value as $k => $v){
				 			if( $v === '' ){
				 				//unset($value[$k]);
				 				$value[$k] = $this->leftBlank;
				 			}else{
				 				$value[$k] = $this->_getAnswerOpt($v);
				 			}
				 		}

				 		if( empty($value) ){
				 			continue;
				 		}
			 		}
			 		
			 		$value = $this->_getAnswerOpt($value, true);
			 		

			 		$qns['children'][$x]['uploaded'][$q]['answer'] = $value;
			 		//$qns[$counter]['answer'] = $value;
			 	}
			 	//$counter++;

			 	//tt($qns, true);

			 	//$this->record->saveModel($qns);
			 	
			 }
				//tt($this->branch_rank, true, 'Branch ID: ' . $branch_id . "\n Date: " . $qdate);
			 //$this->_saveUpdateBranchRank($branch_id);
		}

		tt($qns);

		return true;
	}

	private function saveQns($qns)
	{

	}

	private function _saveUpdateBranchRank($id)
	{
		$this->branch->updateRank($id, $this->branch_rank);
		$this->branch_rank = 0;
	}

	private function _getAnswerOpt($value, $json_encode=false)
	{
		if( ! is_array($value) ){

			if( isset($this->answerOpt[$value]) ){
				$r = $this->answerOpt[$value];
				$this->branch_rank += $r['alias'];
				$x = $r['name'];
			}else{
				$x = $value;
			}

		}else{
			$x = $value;
		}

		return ( $json_encode === false ) ? $x : json_encode($x);
	}

	public function authStaffToken()
	{
		$data = Input::all();

		//Lets Authenticate Token
		$status = $this->staff->checkToken($data);

		return ( empty($status) ) ? false : true;
	}

	protected function setErrorMsg($msg)
	{
		$this->errorMsg[] = $msg;
	}
}


*/