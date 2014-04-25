<?php

class PlaylistController extends BaseController {
	protected $layout = 'application';
	protected $playlist;

	public function __construct()
  {
    $this->beforeFilter('@find_playlist_by_ID_or_raise_404', array('only' => array('show','edit','update','delete', 'up', 'down', 'removeMediaFromPlaylist')));
    $this->beforeFilter('@authed_user_owns_playlist', array('only' => array('show', 'edit','update','delete','up','down', 'removeMediaFromPlaylist')));
  }


	public function newPlaylist() {
		$error_messages = Session::get('errors');

		$data = array('error_messages' => $error_messages);
		$this->layout->content = View::make('playlists.new')->with($data);
	}

	public function create() {
		$this->playlist = new Playlist();

		$this->playlist->user_id 		 = Auth::user()->getAuthIdentifier();
		$this->playlist->title 			 = Input::get('title');
		$this->playlist->description = Input::get('description');
		if($this->playlist->save()){
			return Redirect::route('playlist', array('id' => $this->playlist->getID()));
		} else{
			$data = array('errors' => $this->playlist->errors);
			return Redirect::route('new_playlist')->with($data)->withInput();
		}
	}

	public function show($id)
	{
		$data = array('playlist' => $this->playlist);
		$this->layout->content = View::make('playlists.show')->with($data);
	}

	public function edit($id)
	{
		$data = array('playlist' => $this->playlist);
		$error_messages = Session::get('errors');
		$data = array('playlist' => $this->playlist,'error_messages' => $error_messages);
		$this->layout->content = View::make('playlists.edit')->with($data);
	}

	public function update() {
		$this->playlist->title 			 = Input::get('title');
		$this->playlist->description = Input::get('description');
		if($this->playlist->save()){
			return Redirect::route('playlist', array('id' => $this->playlist->getID()));
		} else{
			$data = array('errors' => $this->playlist->errors);
			return Redirect::route('edit_playlist', array('id' => $this->playlist->getID()))->with($data)->withInput();
		}
	}

	public function delete(){
		$this->playlist->destroy();
		return Redirect::route('home');
	}

	public function addMediaToPlaylist($id) {
		$this->playlist = Playlist::getByID(Input::get('playlist'));

		if($this->playlist != NULL && $this->playlist->getOwner()->getAuthIdentifier() == Auth::user()->getAuthIdentifier()){
			$this->playlist->addMediaToPlaylist($id);
			$this->playlist->save();
			return Redirect::route('playlist', array('id' => $this->playlist->getID()));
		} else{
			return Redirect::route('media', array('id' => $id));
		}
	}

	public function removeMediaFromPlaylist($id, $media_id){
		$this->playlist->removeMediaFromPlaylist($media_id);
		$this->playlist->save();

		return Redirect::route('playlist', array('id' => $this->playlist->getID()));
	}

	public function up($id, $order) {
		$this->playlist->movePlaylistItemUp($order);
		$this->playlist->save();

		return Redirect::route('playlist', array('id' => $this->playlist->getID()));
	}

	public function down($id, $order) {
		$this->playlist->movePlaylistItemDown($order);
		$this->playlist->save();

		return Redirect::route('playlist', array('id' => $this->playlist->getID()));
	}

	public function find_playlist_by_ID_or_raise_404(){
		$this->playlist = Playlist::getByID(Route::input('id'));
		if($this->playlist == NULL){
			App::abort(404);
		}
	}

	public function authed_user_owns_playlist(){
		if($this->playlist->getOwner()->getAuthIdentifier() != Auth::user()->getAuthIdentifier()){
			return Redirect::route('home');
		}
	}
}