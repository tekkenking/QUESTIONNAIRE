<?php

class BaseController extends Controller {

	public $restful = true;
	public $layout 	= 'layouts.master';

	//public function __construct(){}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
			$this->assets();

			    $this->layout->title = '';
				$this->layout->html_attr = "";
				$this->layout->body_attr = "";
				$this->layout->header = View::make('layouts.nonsecure.header');
				$this->layout->sidepanel = '';
		}
	}

	protected function assets()
	{
		Larasset::start()->vendor_dir = 'asset_vendors/';

		$css = [
				'smart.css'	=> [
					'bootstrap' 		=> 'bootstrap.min.css',
					'fontawesome' 		=> 'font-awesome.min.css',
					'smart_production'	=> 'smartadmin-production.min.css',
					'smart_skin'		=> 'smartadmin-skins.min.css'
				],

				'bucketcodes.css' => [
					'main'				=> 'main.css',
					'main-fonts'		=> 'main-fonts.css'
				]
		];

		$js = [

				'smart.js.libs'	=> [
					'jquery'			=>	'jquery-2.0.2.min.js',
					'jquery-ui'			=>	'jquery-ui-1.10.3.min.js',
				],

				'smart.js.bootstrap' => [
					'bootstrap'			=>	'bootstrap.min.js',
				],

				'bucketcodes.js'		=>	[
					'debugger'			=>	'debugger.js'
				]
		];


		Larasset::start('header')
					->storecss($css)
					->css('main-fonts', 'bootstrap', 'fontawesome', 'smart_production', 'smart_skin', 'main');

		Larasset::start()->storejs($js);

		Larasset::start('header')->js('jquery', 'jquery-ui');

		Larasset::start('footer')->js('bootstrap', 'debugger');
	}

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

}
