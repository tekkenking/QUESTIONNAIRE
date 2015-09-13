<?php namespace libs\Repo\Record\Form;

use libs\Form\Form as Form;
use libs\Repo\Record\Record_Eloquent as Model;

class Record_form extends Form{

	public function __construct(Model $record){
		$this->record = $record;
		$this->model = $this->record->newModel();
	}

	public function prepareRange($range)
	{
		return sqlDateRange($range);

		/*$dateArr = explode('-', $range);

		$from = $this->dateFrom($dateArr[0]);
		$to = $this->dateTo($dateArr[1]);

		return ['from'=> $from, 'to'=> $to];*/


		/*$date = $this->allinputs['searchdate'];
		$from = sqldate( $date );

			$parts = explode('/', $date);
			$parts[1] = $parts[1] + 1;
			$toPart = implode('/', $parts);

		$to = sqldate( $toPart );
		return [ $from, $to ];*/
	}

	/*private function dateFrom($from)
	{
		return sqldate($from);
	}	

	private function dateTo($to)
	{
		return sqldate($to);
	}*/

	//We log issue
	protected function extendBeforeUpdate($options = null){
		$this->allinputs['issue_state'] = 1;
		$this->allinputs['issue_created_at'] = sqldate();


		if($this->allinputs['toggle'] != 'add'){
			$this->allinputs['issue_state'] = NULL;
			$this->allinputs['issue_created_at'] = NULL;
		}

		unset( $this->allinputs['toggle'] );

		//tt($this->allinputs);
	}
}