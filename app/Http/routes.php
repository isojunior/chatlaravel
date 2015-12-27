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
//get
Route::get('/', 'UserController@getLoginView');
Route::get('register', 'UserController@getRegisterView');

//post
Route::post('login', 'UserController@processLogin');
Route::post('register', 'UserController@processRegister');