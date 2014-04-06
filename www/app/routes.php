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
	return View::make('register')->with(array('error_messages' => Session::get('errors')));
}));

Route::post('/register', array('as' => 'create_user', 'uses'=> 'UserController@create'));
Route::post('/signin', array('as' => 'signin', 'uses' => 'AuthenticationController@authenticate'));
Route::get('/signout', array('as' => 'signout', 'uses' => 'AuthenticationController@logout'));

//Searching

Route::get('/search/{phrase}', array('as' => 'search', 'uses' => 'SearchController@index'));
Route::post('/search', array('as' => 'start_search', 'uses' => 'SearchController@search'));

//Subscription

Route::get('/subscribe/{id}', array('before' => 'auth', 'as' => 'subscribe_to_user', 'uses' =>'SubscriptionController@subscribe'));
Route::get('/unsubscribe/{id}', array('before' => 'auth', 'as' => 'unsubscribe_from_user', 'uses' =>'SubscriptionController@unsubscribe'));
Route::get('/my_subscriptions', array('before' => 'auth', 'as' => 'my_subscriptions', 'uses' => 'SubscriptionController@index'));

//Messages

Route::get('/messages', array('before' => 'auth', 'as' => 'messages', 'uses' => 'MessageController@index'));
Route::get('/messages/sent', array('before' => 'auth', 'as' => 'sent_messages', 'uses' => 'MessageController@sent'));
Route::get('/messages/new', array('before' => 'auth', 'as' => 'new_message', 'uses' => 'MessageController@newMessage'));
Route::get('/messages/{id}', array('before' => 'auth', 'as' => 'message', 'uses' => 'MessageController@show'));
Route::post('/messages/new', array('before' => 'auth', 'as' => 'create_message', 'uses' => 'MessageController@create'));

// Media

Route::get('/media/new', array('before' => 'auth', 'as' => 'new_media', 'uses' => 'MediaController@newMedia'));
Route::post('/media', array('before' => 'auth', 'as' => 'create_media', 'uses' => 'MediaController@create'));

Route::get('/media/{id}', array('as' => 'media', 'uses' => 'MediaController@show'));
Route::get('/media/{id}/delete', array('before' => 'auth', 'as' => 'delete_media', 'uses' => 'MediaController@delete'));
Route::get('/media/{id}/download', array('as' => 'download_media', 'uses' => 'MediaController@download'));
Route::get('/media/{id}/favorite', array('before' => 'auth', 'as' => 'favorite_media', 'uses' => 'MediaController@favorite'));
Route::post('/media/{id}/add_to_playlist', array('before' => 'auth', 'as' => 'add_media_to_playlist', 'uses' => 'PlaylistController@addMediaToPlaylist'));
Route::post('/media/{id}/add_comment', array('before' => 'auth', 'as' => 'add_comment_to_media', 'uses'=>'CommentController@create'));


// Browsing

Route::get('/browse/{category}', array('as' => 'browse_category', 'uses' =>'BrowseController@browseCategory'));

Route::get('/uploaded/{userid}', array('as' => 'uploaded', 'uses' => 'BrowseController@browseUploaded'));
Route::get('/downloaded/{userid}', array('as' => 'downloaded', 'uses' => 'BrowseController@browseDownloaded'));
Route::get('/viewed/{userid}', array('as' => 'viewed', 'uses' => 'BrowseController@browseViewed'));
Route::get('/favorited/{userid}', array('as' => 'favorited', 'uses' => 'BrowseController@browseFavorited'));


//Profile
Route::get('/profile/{id}', array('as' => 'profile', 'uses' =>'UserController@show'));


// Playlists
Route::get('/playlists/new', array('before' => 'auth', 'as' => 'new_playlist', 'uses' => 'PlaylistController@newPlaylist'));
Route::post('/playlists', array('before' => 'auth', 'as' => 'create_playlist' ,'uses' => 'PlaylistController@create'));
Route::get('/playlists/{id}', array('before' => 'auth', 'as' => 'playlist', 'uses' => 'PlaylistController@show'));
Route::get('/playlists/{id}/edit', array('before' => 'auth', 'as' => 'edit_playlist', 'uses' => 'PlaylistController@edit'));
Route::post('/playlists/{id}', array('before' => 'auth', 'as' => 'update_playlist', 'uses' => 'PlaylistController@update'));
Route::get('/playlists/{id}/up/{order}', array('before' => 'auth', 'as' => 'move_playlist_item_up', 'uses' => 'PlaylistController@up'));
Route::get('/playlists/{id}/down/{order}', array('before' => 'auth', 'as' => 'move_playlist_item_down', 'uses' => 'PlaylistController@down'));
Route::get('/playlists/{id}/remove_from_playlist/{media_id}', array('before' => 'auth', 'as' => 'remove_media_from_playlist', 'uses' => 'PlaylistController@removeMediaFromPlaylist'));
Route::get('/playlists/{id}/delete', array('before' => 'auth', 'as' => 'delete_playlist', 'uses' => 'PlaylistController@delete'));