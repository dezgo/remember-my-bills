<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'BillsController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('accounts', 'AccountsController');

Route::resource('bills', 'BillsController');
Route::bind('bills', function($value, $route) {
	return App\Bills::whereSlug($value)->first();
});

Route::get('bills/{id}/pay', 'BillsController@pay');
Route::patch('bills/{id}/pay', 'BillsController@markPaid');