<?php namespace libs\Repo\Questionnaire\form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Questionnaire\Questionnaire_Eloquent as Questionnaire;

class Questionnaire_form extends Baseform
{

	public $qns = [];

	public function __construct( Questionnaire $questionnaire)
	{
		$this->questionnaire = $questionnaire;
		$this->model = $this->questionnaire->newQuestionnaire();
	}

	public function beforeSave($options = null){

		//Lets get Question
		$this->question();

		//Does it have SubQuestion
		if( $this->qns['questionnaire']['has_subquestion'] === 'yes' ){
			$this->subQuestion();
			$this->qns['questionnaire']['option_type'] = null;
		}

		tt($this->qns);
	}

	private function question()
	{
		//Lets get Question first:
		$this->qns['questionnaire']['question'] = $this->allinputs['question'];
		$this->qns['questionnaire']['has_subquestion'] = $this->allinputs['subquestion'];
		$this->qns['questionnaire']['option_type'] = $this->allinputs['optiontype'];
		$this->qns['questionnaire']['active'] = 1;

		$optionCounter = 0;
		foreach ($this->allinputs as $key => $value) {

			if( str_is('checkbox_*', $key) ){
				$optionCounter++;
				$this->qns['options'][$optionCounter] = $value;
			}

			if( str_is('radio_*', $key) ){
				$optionCounter++;
				$this->qns['options'][$optionCounter] = $value;
			}

			if( str_is('opentext_*', $key) ){
				$optionCounter++;
				$this->qns['options'][$optionCounter] = $value;
			}
		}
	}

	private function subQuestion()
	{
		$this->qns['questionnaire']['option_type'] = null;
		//Lets know subQuestion Option Type
		$this->qns['subquestion']['option_type'] = $this->allinputs['subquestion_optiontype'];

		//Label
		$counter = 0;
		$optionCounter = 0;
		foreach( $this->allinputs as $key => $value ){

			//tt(str_is('subquestion_label_*', $key), true);

			if( str_is('subquestion_label_*', $key) ){
				$counter++;
				$optionCounter = 0;
				$this->qns['subquestion'][$counter]['label'] = $value;
				$this->qns['subquestion'][$counter]['active'] = 1;
			}

			if( str_is('subquestion_'.$counter, $key) ){
				$this->qns['subquestion'][$counter]['sub_question'] = $value;
			}			

			if( str_is('checkbox_*', $key) ){
				$optionCounter++;
				$this->qns['options'][$counter]['options'][$optionCounter] = $value;
			}

			if( str_is('radio_*', $key) ){
				$optionCounter++;
				$this->qns['options'][$counter]['options'][$optionCounter] = $value;
			}

			if( str_is('opentext_*', $key) ){
				$optionCounter++;
				$this->qns['options'][$counter]['options'][$optionCounter] = $value;
			}
			
		}
	}

}