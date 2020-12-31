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

Route::get('/','HomeController@home');

Route::get('bypass-login','AuthController@loginUsingId');

Route::post('post/store', array('uses' => 'PostController@store'));

Route::get('invoice', array('as' => 'bill.index', 'uses' => 'HomeController@generateBill'));

Route::group(['before' => 'guest'], function(){
	Route::controller('password', 'RemindersController');
	Route::get('login', ['as'=>'login','uses' => 'AuthController@login']);
	Route::post('login', array('uses' => 'AuthController@doLogin'));
});

Route::group(array('before' => 'auth'), function()
{

	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
	Route::get('dashboard', array('as' => 'dashboard', 'uses' => 'DashboardController@dashboard'));
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
	Route::post('month/bazar/delete/{id}', array('as' => 'month.bazar.delete', 'uses' => 'BazarController@destoryBazar'));

	// Meal Count
	
	// Route::get('month/meal/show/{id}', array('as' => 'month.meal.show', 'uses' => 'MealCountController@show'));
	Route::get('meal/senddetails/{id}', array('as' => 'month.meal.details.mail', 'uses' => 'MealCountController@sendEmailOfMealDetails'));
	Route::get('meal/invoice/{id}', array('as' => 'month.meal.invoice.mail', 'uses' => 'MealCountController@emailInvoiceOfMealDetails'));

	Route::get('month/{id}/meals', array('as' => 'month.meal.index', 'uses' => 'MealCountController@index'));
	Route::get('month/{id}/meal/create', array('as' => 'month.meal.create', 'uses' => 'MealCountController@create'));

	Route::post('month/{id}/meal/store', array('as' => 'month.meal.store', 'uses' => 'MealCountController@store'));

	Route::get('month/meal/edit/{id}', array('as' => 'month.meal.edit', 'uses' => 'MealCountController@edit'));
	Route::put('month/meal/update/{id}', array('as' => 'month.meal.update', 'uses' => 'MealCountController@update'));
	Route::delete('month/meal/delete/{id}', array('as' => 'month.meal.delete', 'uses' => 'MealCountController@destory'));
    Route::get('month/{id}/mealrate', array('as' => 'month.meal.rate', 'uses' => 'HomeController@mealRateCalculate'));

	// Users/Flats Crud
	Route::get('users', array('as' => 'user.index', 'uses' => 'FlatController@index'));
	Route::get('user/create', array('as' => 'user.create', 'uses' => 'FlatController@create'));
	Route::get('user/show/{id}', array('as' => 'user.show', 'uses' => 'FlatController@show'));
	
	Route::post('user/store', array('as' => 'user.store', 'uses' => 'FlatController@store'));
	Route::get('user/edit/{id}', array('as' => 'user.edit', 'uses' => 'FlatController@edit'));
	Route::put('user/update/{id}', array('as' => 'user.update', 'uses' => 'FlatController@update'));
	Route::delete('user/delete/{id}', array('as' => 'user.delete', 'uses' => 'FlatController@destory'));


	// Bill View (Meal)
    


});


Route::get('/{user}', array('as' => 'user.month', 'uses' => 'HomeController@showMonthByUser'));