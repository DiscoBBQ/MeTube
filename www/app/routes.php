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

Route::get('/', 'HomeController@index');

Route::get('/signin', function()
{
	return View::make('signin');
});

Route::get('/register', function()
{
	return View::make('register');
});

Route::post('/register', 'UserController@create');

Route::post('/signin', 'AuthenticationController@authenticate');

Route::get('/signout', 'AuthenticationController@logout');

Route::get('/search/{phrase}/{page}', 'SearchController@index');
Route::post('/search', 'SearchController@search');

Route::get('/upload', 'UploadController@index');
Route::post('/upload', 'MediaController@upload');

Route::get('/channel', 'ChannelController@index');

Route::get('/secret', array('before' => 'auth', 'uses' => 'SecretController@test'));

Route::get('/media/{id}', 'MediaController@index');

Route::get('/download/{id}', 'MediaController@download');

Route::get('/browse/{category}/{page}', 'BrowseController@index');