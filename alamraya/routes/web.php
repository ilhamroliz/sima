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

	//==== project team
	Route::get('manajemen-project/tim-pelaksana', 'ProjectTeamController@index');
	Route::get('manajemen-project/tim-pelaksana/project/{kode}', 'ProjectTeamController@projectTeam');
	Route::post('manajemen-project/tim-pelaksana/getData', 'ProjectTeamController@getData');
	Route::post('manajemen-project/tim-pelaksana/addTeam', 'ProjectTeamController@addTeam');
	Route::get('manajemen-project/tim-pelaksana/deleteTeam', 'ProjectTeamController@deleteTeam');

	//==== daftar team
	Route::get('manajemen-team/daftar-team', 'DaftarTeamController@index');
	Route::get('manajemen-team/get-team/{status}', 'DaftarTeamController@data');
});