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

Route::get('/','HomeController@showWelcome');

Route::group(['before' => 'guest'], function(){
	Route::controller('password', 'RemindersController');
	Route::get('login', ['as'=>'login','uses' => 'AuthController@login']);
	Route::post('login', array('uses' => 'AuthController@doLogin'));
});

Route::group(array('before' => 'auth'), function()
{

	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
	Route::get('dashboard', array('as' => 'dashboard', 'uses' => 'AuthController@dashboard'));
	Route::get('change-password', array('as' => 'password.change', 'uses' => 'AuthController@changePassword'));
	Route::post('change-password', array('as' => 'password.doChange', 'uses' => 'AuthController@doChangePassword'));
	// Member Crud
	Route::get('members', array('as' => 'member.index', 'uses' => 'MemberController@index'));
	Route::get('member/create', array('as' => 'member.create', 'uses' => 'MemberController@create'));
	Route::get('member/show/{id}', array('as' => 'member.show', 'uses' => 'MemberController@show'));
	
	Route::post('member/store', array('as' => 'member.store', 'uses' => 'MemberController@store'));
	Route::get('member/edit/{id}', array('as' => 'member.edit', 'uses' => 'MemberController@edit'));
	Route::put('member/update/{id}', array('as' => 'member.update', 'uses' => 'MemberController@update'));
	Route::delete('member/delete/{id}', array('as' => 'member.delete', 'uses' => 'MemberController@destory'));


	// Month Crud
	Route::get('months', array('as' => 'month.index', 'uses' => 'MonthController@index'));
	Route::get('month/create', array('as' => 'month.create', 'uses' => 'MonthController@create'));
	Route::get('month/show/{id}', array('as' => 'month.show', 'uses' => 'MonthController@show'));
	
	Route::post('month/store', array('as' => 'month.store', 'uses' => 'MonthController@store'));
	Route::get('month/edit/{id}', array('as' => 'month.edit', 'uses' => 'MonthController@edit'));
	Route::put('month/update/{id}', array('as' => 'month.update', 'uses' => 'MonthController@update'));
	Route::delete('month/delete/{id}', array('as' => 'month.delete', 'uses' => 'MonthController@destory'));

	// Bazars
	Route::get('month/{id}/bazars', array('as' => 'month.bazar.index', 'uses' => 'BazarController@index'));
	Route::get('month/{id}/bazar/create', array('as' => 'month.bazar.create', 'uses' => 'BazarController@create'));
	// Route::get('month/{id}/bazar/show/{id}', array('as' => 'month.bazar.show', 'uses' => 'BazarController@show'));
	
	Route::post('month/{id}/bazar/store', array('as' => 'month.bazar.store', 'uses' => 'BazarController@store'));
	Route::get('month/bazar/edit/{id}', array('as' => 'month.bazar.edit', 'uses' => 'BazarController@edit'));
	Route::put('month/bazar/update/{id}', array('as' => 'month.bazar.update', 'uses' => 'BazarController@update'));
	Route::delete('month/{id}/bazar/delete/{id}', array('as' => 'month.bazar.delete', 'uses' => 'BazarController@destory'));



});