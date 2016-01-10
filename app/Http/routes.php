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

Route::get('/', 'UserController@getLoginView');
Route::get('login', 'UserController@getLoginView');
Route::get('/testJa', 'UserController@testJTGService');
Route::get('/testJa2', 'UserController@getFaculty');
Route::post('login', 'UserController@processLogin');

Route::group(['middleware' => 'guest'], function () {
	Route::get('register', 'UserController@getRegisterView');
	Route::get('chats', 'ChatController@getChatView');
	Route::get('contacts', 'ContactController@getContactView');
	Route::get('profile', 'UserController@getProfileView');
	Route::get('profile/edit', 'UserController@editProfileView');
	Route::get('logout', 'UserController@processLogout');

	Route::post('register', 'UserController@processRegister');
	Route::post('profile/edit', 'UserController@processEditProfile');
});
