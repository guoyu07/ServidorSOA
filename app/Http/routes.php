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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['cors']], function () {
	Route::resource('/users', 'UserController', ['only'=>['index','store','update','destroy','show']]);
	Route::put('/users/{id}/password', 'UserController@changePassword');
	Route::get('/token', 'UserController@getToken');
	Route::get('/java', 'HomeController@downloadJava');
	Route::get('/android', 'HomeController@downloadAndroid');
	Route::post('/login', 'HomeController@login');
});
