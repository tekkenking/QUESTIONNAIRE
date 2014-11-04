<?php  namespace libs\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind( 'libs\Repo\branch\form\Branch_form' );
		$this->app->bind( 'libs\Repo\Questionnaire\form\Questionnaireform' );
	}
}