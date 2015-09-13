<?php namespace libs\Repo\Question\form;

use libs\Form\Baseform as Baseform;
use libs\Repo\Question\Question_Eloquent as Question;
use libs\Repo\Answer\Answer_Eloquent as Answer;
use libs\Repo\Subquestion\Subquestion_Eloquent as subQuestion;
use Input;

class Question_form extends Baseform
{

	public $qns = [];

	public $settings = [
		'doubleopentext_blue' => ':::'
	];

	public function __construct( Question $question, Answer $answer, subQuestion $sub_question)
	{
		$this->question = $question;
		$this->model = $this->question->newQuestion();
		$this->answer = $answer;
		$this->sub_question = $sub_question;
	}

	public function beforeSave($options = null){

		//tt(Input::all());

		//Lets get Question
		$this->question();

		//tt($this->qns);

		//Does it have sub_question
		if( $this->qns['questionnaire']['has_sub_question'] == 1 ){
			$this->subQuestion();
		}

		$this->allinputs = $this->qns;

		//tt($this->allinputs);
		
		return $this->allinputs;
	}

	private function question()
	{
		//Lets get Question first:
		$this->qns['questionnaire']['questionnairecategories_id'] = $this->allinputs['questioncat'];
		$this->qns['questionnaire']['questionnairesubcategories_id'] = $this->allinputs['questionsubcat'];
		$this->qns['questionnaire']['label'] = $this->allinputs['question_label'];


		$this->qns['questionnaire']['question'] = $this->allinputs['question'];
		$this->qns['questionnaire']['has_sub_question'] = $this->allinputs['subquestion'];

		if( $this->qns['questionnaire']['has_sub_question'] == 0 )
		{
			$this->qns['answers']['answer_type'] = $this->allinputs['optiontype'];
		}

		$this->qns['questionnaire']['active'] = 1;

		if( $this->qns['questionnaire']['has_sub_question'] == 0 ){
			//This code must be skipped if sub_question is 1
			$optionCounter = 0;
			foreach ($this->allinputs as $key => $value) {

				if( str_is('option_*', $key) ){
					$optionCounter++;
					$this->qns['answers'][$optionCounter] = ( $this->qns['answers']['answer_type'] == 'opentext' ) ? 'Offered answer text' : $value;
				}
			}
		}
	}

	private function subQuestion()
	{
		//$this->qns['questionnaire']['answer_type'] = null;
		//Lets know subQuestion Option Type
		$this->qns['sub_question']['answer_type'] = $this->allinputs['subquestion_optiontype'];

		//Label
		$counter = 0;
		$optionCouner = 0;

		//tt($this->allinputs);

		foreach( $this->allinputs as $key => $value ){

			//tt(str_is('subquestion_label_*', $key), true);

			if( str_is('answertype_*', $key) ){
				$counter++;
				$this->qns['sub_question'][$counter]['answer_type'] = $value;
			}

			if( str_is('subquestion_label_*', $key) ){
				$optionCounter = 0;
				$this->qns['sub_question'][$counter]['label'] = $value;
				$this->qns['sub_question'][$counter]['active'] = 1;
			}

			if( str_is('subquestion_*', $key) && ('subquestion_optiontype' !== $key) ){

				if( is_array($value) ){
					$this->qns['sub_question'][$counter]['sub_question'] = implode($this->settings['doubleopentext_blue'], $value);
				}else{
					$this->qns['sub_question'][$counter]['sub_question'] = $value;
				}
			}

			if( str_is('option_*', $key) ){
				$optionCounter++;
				$ansType = $this->qns['sub_question'][$counter]['answer_type'];

				//tt($ansType, true);

				$this->qns['sub_question'][$counter]['options'][$optionCounter] = 
				( $ansType == 'opentext' || $ansType == 'doubleopentext' )  
					? NULL 
					: $value;
			}
		}

		//tt($this->qns);
	}

	public function onlySave(Array $inputs = null)
	{

		//tt($inputs);

		//Lets First Save to Question Table
		$question = $inputs['questionnaire'];
		$questionModel = $this->question->save_questions( $question );

		if( $question['has_sub_question'] == 1 )
		{
			$this->saveSubQuestion( $inputs['sub_question'], $questionModel->id );
			//$this->saveSubQuestion( $inputs['sub_question'], 1 );
		}else{
			$this->saveAnswers( $inputs['answers'], $questionModel->id );
		}

		return true;
	}

	private function saveAnswers( $answerInputs, $questionID ){
		//Lets Save the Answers
		$answers = $answerInputs;
		$answers_to_save['question_id'] = $questionID;
		$answers_to_save['answer_type'] = $answers['answer_type'];
		unset($answers['answer_type']);

		foreach ($answers as $answer) {
			$answers_to_save['option_id'] = $answer;
			$this->answer->save_answers( $answers_to_save );
		}

		return true;
	}

	private function saveSubQuestion( $subquestionInputs, $questionID ){
		$sub_question = $subquestionInputs;

		//tt($sub_question);

		//$subquestion_answers_to_save['answer_type'] = $sub_question['answer_type'];
		unset($sub_question['answer_type']);

		$subquestion_to_save['question_id'] = $questionID;

		foreach ( $sub_question as $array_value ) {

			foreach($array_value as $key => $value){

				if( $key == 'answer_type' ){
					$subquestion_answers_to_save['answer_type'] = $value;
				}

				if( $key == 'options'){
					unset($subquestion_to_save['answer_type']);

					//Save Sub Question
					$subquestionModel = $this->sub_question
										->save_subquestions( $subquestion_to_save );

					foreach ($value as $option) {
						$subquestion_answers_to_save['question_id'] = $questionID;
						$subquestion_answers_to_save['sub_question_id'] = $subquestionModel->id;
						$subquestion_answers_to_save['option_id'] = $option;

						//Save Answers Matching the sub question
						$subquestion_answerModel = $this->answer
											->save_answers( $subquestion_answers_to_save );
					}
					
				}else{

					$subquestion_to_save[$key] = $value;
				}
			}

		}

		return true;
	}

	public function onlyUpdate( $questionID, Array $inputs = null )
	{
		//Lets Update Question
		$this->question->updateByID($inputs['questionnaire'], $questionID);

		//Lets Delete all the question answers
		$answer_ids_array = $this->answer->findIDsByQuestionID($questionID);
		$this->answer->destroy( $answer_ids_array );

		if( $inputs['questionnaire']['has_sub_question'] == 1 ){
			//Lets Delete all the Sub_Question
			$subquestion_ids_array = $this->sub_question->findIDsByQuestionID($questionID);
			$this->sub_question->destroy( $subquestion_ids_array );

			//Lets save subquestion and related answer
			return $this->saveSubQuestion( $inputs['sub_question'], $questionID );
		}else{
			return $this->saveAnswers( $inputs['answers'], $questionID );
		}


	}

}