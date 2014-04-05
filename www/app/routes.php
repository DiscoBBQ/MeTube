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

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::get('/signin', function()
{
	return View::make('signin');
});

Route::get('/register', array('as' => 'register', function()
{
	return View::make('register');
}));

Route::post('/register', 'UserController@create');

Route::post('/signin', array('as' => 'signin', 'uses' => 'AuthenticationController@authenticate'));

Route::get('/signout', array('as' => 'signout', 'uses' => 'AuthenticationController@logout'));

Route::get('/search/{phrase}/{page}', 'SearchController@index');
Route::post('/search', 'SearchController@search');

Route::get('/upload', array('as' => 'upload_form', 'uses' => 'UploadController@index'));
Route::post('/upload', 'MediaController@upload');

Route::get('/channel/{id}/{page}', array('as' => 'channel', 'uses' =>'ChannelController@show'));

Route::get('/secret', array('before' => 'auth', 'uses' => 'SecretController@test'));

Route::get('/media/{id}', array('as' => 'media', 'uses' => 'MediaController@index'));
Route::post('/media/{id}', 'PlaylistController@add');

Route::get('/download/{id}', 'MediaController@download');

Route::get('/favorite/{id}', 'MediaController@favorite');

// Browsing

Route::get('/browse/{category}/{page}', array('as' => 'browse_category', 'uses' =>'BrowseController@browseCategory'));

Route::get('/uploaded/{userid}/{page}', array('as' => 'uploaded', 'uses' => 'BrowseController@browseUploaded'));
Route::get('/downloaded/{userid}/{page}', array('as' => 'downloaded', 'uses' => 'BrowseController@browseDownloaded'));
Route::get('/viewed/{userid}/{page}', array('as' => 'viewed', 'uses' => 'BrowseController@browseViewed'));
Route::get('/favorited/{userid}/{page}', array('as' => 'favorited', 'uses' => 'BrowseController@browseFavorited'));


//Profile

Route::get('/profile/{id}', array('as' => 'profile', 'uses' =>'ProfileController@index'));

Route::get('/subscribe/{id}', 'SubscriptionController@subscribe');


// Playlists
Route::get('/createplaylist', array('as' => 'create_playlist_form', 'uses' => 'CreatePlaylistController@index'));
Route::post('/createplaylist', 'CreatePlaylistController@create');

Route::get('/playlist/up/{id}/{order}/{page}', 'PlaylistController@up');
Route::get('/playlist/down/{id}/{order}/{page}', 'PlaylistController@down');
Route::get('/playlist/{id}/{page}', array('as' => 'playlist', 'uses' => 'PlaylistController@index'));

Route::post('/comment/{id}', 'CommentController@create');