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

// put this specific stuff first
Route::get('bills/export', 'BillsController@export');
Route::get('bills/import', 'BillsController@import');
Route::put('bills/import_result', 'BillsController@import_result');
Route::get('bills/{id}/pay', 'BillsController@pay');
Route::patch('bills/{id}/pay', 'BillsController@markPaid');

// then the resource route
Route::resource('bills', 'BillsController');
