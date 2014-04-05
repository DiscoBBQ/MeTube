<?php

class PlaylistController extends BaseController {
	protected $layout = 'application';

	public function __construct()
  {
    $this->beforeFilter('@find_playlist_by_ID_or_raise_404', array('only' => array('show', 'up', 'down')));
    $this->beforeFilter('@authed_user_owns_playlist', array('only' => array('show', 'up','down')));
  }


	public function newPlaylist() {
		$this->layout->content = View::make('playlists.new');
	}

	public function create() {
		$result = DB::select("SELECT * FROM playlist WHERE user_id = ? AND title = ?", array(Auth::user()->id, Input::get('title')));

		if (sizeof($result) == 0) {
			$id = DB::table('playlist')->insertGetId(array('user_id' => Auth::user()->id,
										 'title' => Input::get('title'),
										 'description' => Input::get('description')));

			return Redirect::route('playlist', array('id' => $id, 'page' => 1));
		} else {
			return Redirect::route('new_playlist');
		}
	}

	public function show($id)
	{
		$results = DB::select("SELECT * FROM media,playlist_item WHERE playlist_id = ? AND id = media_id ORDER BY item_order", array($id));
		$data = array('results' => $results, 'playlist_id' => $id);
		$this->layout->content = View::make('playlists.show')->with($data);
	}

	public function add($id) {
		$result = DB::select("SELECT * FROM playlist_item WHERE playlist_id = ? AND media_id = ?", array(Input::get('playlist'), $id));
		if (sizeof($result) == 0){
			DB::statement("INSERT INTO playlist_item (playlist_id, media_id) VALUES (?,?)", array(Input::get('playlist'), $id));
		}

		return Redirect::route('media', array('id' => $id));
	}

	public function up($id, $order) {
		$results = DB::select("SELECT media_id,item_order FROM playlist_item WHERE playlist_id = ? AND item_order < ? ORDER BY item_order LIMIT 1", array($id, $order));

		if (sizeof($results) > 0) {
			$temp_media_id = $results[0]->media_id;
			$temp_item_order = $results[0]->item_order;

			$results = DB::select("SELECT media_id FROM playlist_item WHERE item_order = ?", array($order));
			$current_media_id = $results[0]->media_id;

			DB::statement("UPDATE playlist_item SET media_id = ? WHERE item_order = ?", array($temp_media_id, $order));
			DB::statement("UPDATE playlist_item SET media_id = ? WHERE item_order = ?", array($current_media_id, $temp_item_order));
		}
		return Redirect::route('playlist', array('id' => $id));
	}

	public function down($id, $order) {
		$results = DB::select("SELECT media_id,item_order FROM playlist_item WHERE playlist_id = ? AND item_order > ? ORDER BY item_order LIMIT 1", array($id, $order));

		if (sizeof($results) > 0) {
			$temp_media_id = $results[0]->media_id;
			$temp_item_order = $results[0]->item_order;

			$results = DB::select("SELECT media_id FROM playlist_item WHERE item_order = ?", array($order));
			$current_media_id = $results[0]->media_id;

			DB::statement("UPDATE playlist_item SET media_id = ? WHERE item_order = ?", array($temp_media_id, $order));
			DB::statement("UPDATE playlist_item SET media_id = ? WHERE item_order = ?", array($current_media_id, $temp_item_order));
		}
		return Redirect::route('playlist', array('id' => $id));
	}

	public function find_playlist_by_ID_or_raise_404(){
		$result = DB::select("SELECT id FROM playlist WHERE id = ?", array(Route::input('id')));
		if(sizeof($result) <= 0){
			App::abort(404);
		}
	}

	public function authed_user_owns_playlist(){
		$result = DB::select("SELECT id FROM playlist WHERE id = ? AND user_id = ?", array(Route::input('id'), Auth::user()->getAuthIdentifier()));
		if(sizeof($result) <= 0){
			return Redirect::route('home');
		}
	}
}