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

Route::get('/channel/{id}/{page}', 'ChannelController@index');

Route::get('/secret', array('before' => 'auth', 'uses' => 'SecretController@test'));

Route::get('/media/{id}', 'MediaController@index');
Route::post('/media/{id}', 'PlaylistController@add');

Route::get('/download/{id}', 'MediaController@download');

Route::get('/favorite/{id}', 'MediaController@favorite');

Route::get('/browse/{category}/{page}', 'BrowseController@index');

Route::get('/uploaded/{userid}/{page}', 'BrowseUploadedController@index');
Route::get('/downloaded/{userid}/{page}', 'BrowseDownloadedController@index');
Route::get('/viewed/{userid}/{page}', 'BrowseViewedController@index');
Route::get('/favorited/{userid}/{page}', 'BrowseFavoritedController@index');

Route::get('/profile/{id}', 'ProfileController@index');

Route::get('/subscribe/{id}', 'SubscriptionController@subscribe');

Route::get('/createplaylist', 'CreatePlaylistController@index');
Route::post('/createplaylist', 'CreatePlaylistController@create');

Route::get('/playlist/up/{id}/{order}/{page}', 'PlaylistController@up');
Route::get('/playlist/down/{id}/{order}/{page}', 'PlaylistController@down');
Route::get('/playlist/{id}/{page}', 'PlaylistController@index');

Route::post('/comment/{id}', 'CommentController@create');