<?php


//tt(Config::get('database.'))
//tt(phpinfo());

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
				'uses' => 'RecordsController@index',
				'as'	=> 'home'
			]);

// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
	Route::get('/', [ 'uses' => 'ApiController@index', 'as'=>'api.home']);
	
	Route::get('updateappinfo', [ 'uses' => 'ApiController@updateAppInfo', 'as'=>'api.updateappinfo']);

	Route::post('saveappdata', [ 'uses' => 'ApiController@saveAppData', 'as'=>'api.saveAppData']);

    Route::get('checkserver', [ 'uses' => 'ServerController@isServerfound', 'as' => 'checkserver']);

    Route::post('authstafftoken', [ 'uses' => 'ApiController@authStaffToken', 'as' => 'authstafftoken']);
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
Route::post('branches/state/{id}', [ 'uses' => 'BranchesController@toggleState', 'as' => 'branches.togglestate']);

/** QUESTIONNAIRES **/
Route::resource('questionnaires', 'QuestionnairesController');

Route::post('questionnaires/delete', [ 'uses' => 'QuestionnairesController@delete', 'as' => 'questionnaires.delete']);

Route::post('questionnaires/state/{id}', [ 'uses' => 'QuestionnairesController@toggleState', 'as' => 'questionnaires.togglestate']);

Route::get('questionnaires/category/{id}/create', [
		'uses' 	=> 'QuestionnairesController@createByCategory',
		'as'	=> 'questionnaires.createbycategory'
	]);

/** QUESTIONNAIRE CATEGORY **/
Route::resource('questionnairecategories', 'QuestionnairecategoriesController');
Route::post('questionnairecategories/getchildren/{id}',[
		'uses'	=> 'QuestionnairecategoriesController@getChildren',
		'as'	=> 'questionnairecategories.getchildren'
	]);

/** QUESTIONNAIRE SUB CATEGORY **/
Route::resource('questionnairesubcategories', 'QuestionnairesubcategoriesController');
Route::get('questionnairesubcategories/create/{id}',[
		'uses'	=> 'QuestionnairesubcategoriesController@createForCategory',
		'as'	=> 'questionnairesubcategories.create.forcategory'
	]);

/** RECORDS **/
Route::resource('records', 'RecordsController');
Route::get('records/search/get', [
		'uses' 	=> 'RecordsController@searchForDate', 
		'as' 	=> 'records.search'
	]);

Route::get('records/search/date', [
		'uses' 	=> 'RecordsController@searchByDate', 
		'as' 	=> 'records.search.date'
	]);

Route::post('records/filterby/{option}', [
		'uses' => 'RecordsController@filterBy', 
		'as' => 'records.filterby'
	]);

Route::get('records/popover/view', [
		'uses'	=> 'RecordsController@popover',
		'as'	=> 'records.popover'
	]);

Route::post('records/toggleissue', [
		'uses'	=> 'RecordsController@toggleIssue',
		'as'	=> 'record.issue.toggle'
	]);

/** STAFFS **/
Route::resource('staffs', 'StaffsController');
Route::post('staffs/delete', [ 'uses' => 'StaffsController@delete', 'as' => 'staffs.delete']);
Route::post('staffs/{id}/lock', [ 'uses' => 'StaffsController@toggleLock', 'as' => 'staffs.lockstatus']);
Route::post('staffs/{id}/togglestate', [ 'uses' => 'StaffsController@togglestate', 'as' => 'staffs.togglestate']);

/** OPTIONS **/
Route::resource('options', 'OptionsController');

Route::get('options/index/floatview', [
		'uses' 	=> 'OptionsController@floatview',
		'as'	=> 'options.floatview'
	]);


/* ISSUES */
Route::resource('issues', 'IssuesController');

/*Route::post('pin/issues', [
				'uses'	=> 'IssuesController@pinIssue',
				'as'	=> 'issue.toggle'
			]);*/

Route::get('pin/issues/search', [
		'uses'	=>	'IssuesController@search',
		'as'	=>	'issue.search'
	]);

Route::post('issue/resolve', [
		'uses'	=>	'IssuesController@resolve',
		'as'	=>	'issue.resolve'
	]);

/* BACKUP AND RESTORE SQLITE */
Route::resource('backuprestoredbs', 'BackuprestoredbsController');