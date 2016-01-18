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

Route::get('socket', 'SocketController@index');
Route::post('sendMessage', 'SocketController@sendMessage');
Route::get('writeMessage', 'SocketController@writeMessage');
Route::get('/', 'UserController@getLoginView');
Route::get('login', 'UserController@getLoginView');
Route::get('main', 'UserController@getLoginView');
Route::get('register', 'UserController@getRegisterView');
Route::get('api/getFaculty', 'SearchController@getFaculty');
Route::post('login', 'UserController@processLogin');
Route::post('register', 'UserController@processRegister');
Route::group(['middleware' => 'guest'], function () {
	Route::get('chats', 'ChatController@getChatListView');
	Route::get('chat/{idGroup}', 'ChatController@getChatView');
	Route::get('chatWith/{idUser}', 'ChatController@getUserChatView');
	Route::get('contacts', 'ContactController@getContactView');
	Route::get('profile', 'UserController@getProfileView');
	Route::get('profile/edit', 'UserController@editProfileView');
	Route::get('logout', 'UserController@processLogout');
	Route::get('setupUniversity', 'UserController@getSetupUniversityView');
	Route::post('uploadProfileImage', 'UserController@uploadProfileImage');
	Route::post('profile/edit', 'UserController@processEditProfile');
	Route::post('setupUniversity', 'UserController@processSetupUniversityView');
	Route::get('authorizedList', 'ContactController@getAuthorizedResult');
	Route::get('authorizedUser/{authorizeStatus}/{idUser}', 'ContactController@processAuthorizeUser');
	Route::post('chat/sendMessage', 'ChatController@sendMessage');
});
Route::get('iso', function () {
	$user = Session::get('user');
	Return view("isohome")->with('user', $user);
});
Route::get('systemMessage', 'SocketController@systemMessage');
