<?php namespace libs\Repo\Questionnaire;

use Questionnaire as Questionnaire;

class Questionnaire_Eloquent implements Questionnaire_Interface
{

	public function newQuestionnaire()
	{
		return new Questionnaire;
	}

	public function listAll()
	{
		return Questionnaire::all();
	}

	public function find($id)
	{
		return Questionnaire::find($id);
	}

	public function destroy($ids)
	{
		return Questionnaire::destroy($ids);
	}

}

