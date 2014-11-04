<?php namespace libs\Repo\Questionnaire;

Interface Questionnaire_Interface
{

	public function newQuestionnaire();

	public function listAll();

	public function find($id);

	public function destroy($ids);

}