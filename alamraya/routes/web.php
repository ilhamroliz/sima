<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
	Route::get('login', [
	        'uses' => 'LoginController@index',
	        'as' => 'login'
	]);
	Route::get('maintenance', 'LoginController@maintenance');
	Route::post('authe', 'LoginController@authenticate');
});

//================================================================

Route::group(['middleware' => 'auth'], function () {
	Route::get('logout', 'LoginController@logout');
	//==== dashboard
	Route::get('home', [
	        'uses' => 'DashboardController@index',
	        'as' => 'home'
	]);

	Route::get('/', 'DashboardController@index');

	//==== daftar project
	Route::get('manajemen-project/daftar-project', 'DaftarProjectController@index');
	Route::get('manajemen-project/tambah-project', 'DaftarProjectController@add');
	Route::post('manajemen-project/get-project/{status}', 'DaftarProjectController@data');
	Route::get('manajemen-project/daftar-project/{project}/fitur', 'DaftarProjectController@projectFitur');
	Route::post('manajemen-project/daftar-project/get-fitur/{project}', 'DaftarProjectController@getFitur');

	//==== project team
	Route::get('manajemen-project/project-team', 'ProjectTeamController@index');
	Route::get('manajemen-project/project-team/project/{kode}', 'ProjectTeamController@projectTeam');
	Route::post('manajemen-project/project-team/getData', 'ProjectTeamController@getData');
	Route::post('manajemen-project/project-team/addTeam', 'ProjectTeamController@addTeam');
	Route::post('manajemen-project/project-team/deleteTeam', 'ProjectTeamController@deleteTeam');
	Route::post('manajemen-project/project-team/get-data/{status}', 'ProjectTeamController@data');
	Route::get('manajemen-project/project-team/project-position', 'ProjectTeamController@projectPosition');
	Route::get('manajemen-project/project-team/get-position', 'ProjectTeamController@getPosition');
	Route::get('manajemen-project/get-position', 'ProjectTeamController@getPosisi');

	//==== project progress
	Route::get('manajemen-project/project-progress', 'ProjectProgressController@index');
	Route::post('manajemen-project/project-progress/getProjectProgress', 'ProjectProgressController@getProjectProgress');
	Route::get('manajemen-project/project-progress/getTeam', 'ProjectProgressController@getTeam');
	Route::get('manajemen-project/project-progress/project/{kode}', 'ProjectProgressController@projectProgress');
	Route::post('manajemen-project/project-progress/get-progress/{project}', 'ProjectProgressController@dataProgress');
	Route::post('manajemen-project/project-progress/get-project/{project}/save-progress-init', 'ProjectProgressController@saveInit');
	Route::post('manajemen-project/project-progress/get-project/{project}/update-progress-init', 'ProjectProgressController@updateProgress');
	Route::post('manajemen-project/project-progress/get-project/{project}/getProgress', 'ProjectProgressController@getProgress');
	Route::post('manajemen-project/project-progress/get-chat', 'ProjectProgressController@chat');
	Route::post('manajemen-project/project-progress/save-note', 'ProjectProgressController@saveNote');

	//==== daftar team
	Route::get('manajemen-team/daftar-team', 'DaftarTeamController@index');
	Route::get('manajemen-team/get-team/{status}', 'DaftarTeamController@data');
});