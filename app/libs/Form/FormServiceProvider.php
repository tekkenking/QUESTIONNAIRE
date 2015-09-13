<?php  namespace libs\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind( 'libs\Repo\branch\form\Branch_form' );
		$this->app->bind( 'libs\Repo\Question\form\Question_form' );
		$this->app->bind( 'libs\Repo\API\Form\ApiForm' );
		$this->app->bind( 'libs\Repo\Record\Form\Record_form' );
		$this->app->bind( 'libs\Repo\Staff\Form\staff_form' );
		$this->app->bind( 'libs\Repo\Questioncategory\Form\Questioncategory_form' );
		$this->app->bind( 'libs\Repo\Questionsubcategory\Form\Questionsubcategory_form' );
		$this->app->bind( 'libs\Repo\Option\form\Option_form' );
		$this->app->bind( 'libs\Repo\Issue\form\Issue_form' );
	}
}