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

//Registration

Route::get('/signin', array('as' => 'signin_form', function()
{
	return View::make('signin');
}));

Route::get('/register', array('as' => 'register', function()
{
	return View::make('register');
}));

Route::post('/register', array('as' => 'create_user', 'uses'=> 'UserController@create'));
Route::post('/signin', array('as' => 'signin', 'uses' => 'AuthenticationController@authenticate'));
Route::get('/signout', array('as' => 'signout', 'uses' => 'AuthenticationController@logout'));

//Searching

Route::get('/search/{phrase}/{page}', array('as' => 'search', 'uses' => 'SearchController@index'));
Route::post('/search', array('as' => 'start_search', 'uses' => 'SearchController@search'));

//Subscription

Route::get('/channel/{id}/{page}', array('as' => 'channel', 'uses' =>'ChannelController@show'));
Route::get('/subscribe/{id}', array('as' => 'subscribe_to_user', 'uses' =>'SubscriptionController@subscribe'));

// Media

Route::get('/media/new', array('as' => 'new_media', 'uses' => 'MediaController@newMedia'));
Route::post('/media', array('as' => 'create_media', 'uses' => 'MediaController@create'));

Route::get('/media/{id}', array('as' => 'media', 'uses' => 'MediaController@show'));
Route::get('/media/{id}/download', array('as' => 'download_media', 'uses' => 'MediaController@download'));
Route::get('/media/{id}/favorite', array('as' => 'favorite_media', 'uses' => 'MediaController@favorite'));
Route::post('/media/{id}/add_to_playlist', array('as' => 'add_media_to_playlist', 'uses' => 'PlaylistController@add'));
Route::post('/media/{id}/add_comment', array('as' => 'add_comment_to_media', 'uses'=>'CommentController@create'));


// Browsing

Route::get('/browse/{category}/{page}', array('as' => 'browse_category', 'uses' =>'BrowseController@browseCategory'));

Route::get('/uploaded/{userid}/{page}', array('as' => 'uploaded', 'uses' => 'BrowseController@browseUploaded'));
Route::get('/downloaded/{userid}/{page}', array('as' => 'downloaded', 'uses' => 'BrowseController@browseDownloaded'));
Route::get('/viewed/{userid}/{page}', array('as' => 'viewed', 'uses' => 'BrowseController@browseViewed'));
Route::get('/favorited/{userid}/{page}', array('as' => 'favorited', 'uses' => 'BrowseController@browseFavorited'));


//Profile
Route::get('/profile/{id}', array('as' => 'profile', 'uses' =>'UserController@show'));


// Playlists
Route::get('/playlists/new', array('as' => 'new_playlist', 'uses' => 'PlaylistController@newPlaylist'));
Route::post('/playlists', array('as' => 'create_playlist' ,'uses' => 'PlaylistController@create'));
Route::get('/playlists/{id}', array('as' => 'playlist', 'uses' => 'PlaylistController@show'));
Route::get('/playlists/{id}/up/{order}', array( 'as' => 'move_playlist_item_up', 'uses' => 'PlaylistController@up'));
Route::get('/playlists/{id}/down/{order}', array( 'as' => 'move_playlist_item_down', 'uses' => 'PlaylistController@down'));
