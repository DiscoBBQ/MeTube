<?php

class MediaController extends BaseController {
	protected $layout = 'application';
	protected $media;

	public function __construct()
  {
    $this->beforeFilter('@find_media_by_ID_or_raise_404', array('only' => array('show', 'download', 'favorite', 'delete')));
    $this->beforeFilter('@authed_user_owns_media', array('only' => array('delete')));
  }

	public function newMedia(){
		$this->layout->content = View::make('media.new');
	}

	public function show($id)
	{
		if(Auth::check()){
			$result = DB::select("SELECT * FROM interactions WHERE user_id = ? AND media_id = ? AND category = 'viewed'", array(Auth::user()->id, $id));

			if (sizeof($result) == 0){
				DB::statement("INSERT INTO interactions (user_id, media_id, category) VALUES (?,?,'viewed')", array(Auth::user()->id, $id));
			}
		}

		$this->layout->content = View::make('media.show')->with(array('media' => $this->media));
	}

	public function create() {
		$this->media = new Media(Input::get('title'),
						   Input::get('description'),
						   Input::get('category'),
						   Input::get('keywords'),
						   Input::file('file')->getClientOriginalExtension(),
						   Auth::user()->getAuthIdentifier());

		$id = $this->media->save(Input::file('file'));

		if ($id != -1) {
			return Redirect::route('media', array('id' => $id));
		} else {
			return Redirect::route('new_media')->with('error_messages', 'test');
		}
	}

	public function download($id) {
		if(Auth::check()) {
			$result = DB::select("SELECT * FROM interactions WHERE user_id = ? AND media_id = ? AND category = 'downloaded'", array(Auth::user()->id, $id));
			if (sizeof($result) == 0)
				DB::statement("INSERT INTO interactions (user_id, media_id, category) VALUES (?,?,'downloaded')", array(Auth::user()->id, $id));
		}

		return Response::download($this->media->getFullFilename(), $this->media->getDownloadFilename());
	}

	public function favorite($id) {
		if(Auth::check()) {
			$result = DB::select("SELECT * FROM interactions WHERE user_id = ? AND media_id = ? AND category = 'favorited'", array(Auth::user()->id, $id));
			if (sizeof($result) == 0)
				DB::statement("INSERT INTO interactions (user_id, media_id, category) VALUES (?,?,'favorited')", array(Auth::user()->id, $id));
		}
		return Redirect::route('media', array('id' => $id));
	}

	public function delete($id){
		$this->media->destroy();
		return Redirect::route('home');
	}

	public function find_media_by_ID_or_raise_404(){
		$this->media = Media::getByID(Route::input('id'));

		if($this->media == NULL){
			App::abort(404);
		}
	}

	public function authed_user_owns_media(){
		if(Auth::user()->getAuthIdentifier() != $this->media->getAuthor()->getID()){
			return Redirect::route('home');
		}
	}
}