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
App::bind('App\Repositories\BillRepositoryInterface', 'App\Repositories\EloquentBillRepository');

Route::get('/', 'BillsController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('bills', 'BillsController');
Route::bind('bills', function($value, $route) {
	return App\Bills::whereSlug($value)->first();
});