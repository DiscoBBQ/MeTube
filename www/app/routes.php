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

Route::get('/', 'MeTubeController@index');

Route::get('/signin', function()
{
	return View::make('signin');
});

Route::get( '/register', 'UserController@register');
Route::post('/register', 'UserController@create');

Route::post('/signin', 'AuthenticationController@authenticate');

Route::get('/signout', 'AuthenticationController@logout');

Route::get('/search', 'SearchController@index');

Route::get('/upload', 'UploadController@index');

Route::get('/channel', 'ChannelController@index');

Route::get('/secret', array('before' => 'auth', 'uses' => 'SecretController@test'));

Route::get('/profile/update', array('as' => 'profile_edit', 'before' => 'auth',  'uses' => 'UserController@edit'));
Route::post('/profile/update', array('before' => 'auth', 'uses' => 'UserController@update'));

Route::get('/channels/{id}', array('as' => 'user_show', 'uses' => 'UserController@show'));