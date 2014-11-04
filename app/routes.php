<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 
			[
				'uses' => 'HomeController@index',
				'as'	=> 'home'
			]);

// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('testapi', 'TestapiController');
    Route::get('checkserver', [ 'uses' => 'ServerController@isServerfound', 'as' => 'checkserver']);
});//

// Confide routes
Route::get('users/create', [ 'uses' => 'SessionController@create', 'as' => 'session.show.create']);
Route::post('users', [ 'uses' => 'SessionController@store', 'as' => 'session.auth.create']);

Route::get('login', [ 'uses' => 'SessionController@login', 'as' => 'session.show.login']);
Route::post('user/login', ['uses' => 'SessionController@doLogin', 'as' => 'session.auth.login']);

Route::get( 'users/logout', ['uses' => 'BaseController@logout', 'as' => 'session.logout'] );

Route::get('users/confirm/{code}', 'SessionController@confirm');
Route::get('users/forgot_password', 'SessionController@forgotPassword');
Route::post('users/forgot_password', 'SessionController@doForgotPassword');
Route::get('users/reset_password/{token}', 'SessionController@resetPassword');
Route::post('users/reset_password', 'SessionController@doResetPassword');

/** BRANCHES **/
Route::resource('branches', 'BranchesController');
Route::post('branches/delete', [ 'uses' => 'BranchesController@delete', 'as' => 'branches.delete']);

/** QUESTIONNAIRES **/
Route::resource('questionnaires', 'QuestionnairesController');
Route::post('questionnaires/delete', [ 'uses' => 'QuestionnairesController@delete', 'as' => 'questionnaires.delete']);