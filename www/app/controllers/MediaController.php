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
		$error_messages = Session::get('errors');
		$data = array('error_messages' => $error_messages);
		$this->layout->content = View::make('media.new')->with($data);
	}

	public function show($id)
	{
		if(Auth::check()){
			Interaction::logUserViewedMedia(Auth::user()->getAuthIdentifier(), $this->media->getID());
		}

		$error_messages = Session::get('errors');

    $data = array('media' => $this->media, 'error_messages' => $error_messages);

		$this->layout->content = View::make('media.show')->with($data);
	}

	public function create() {
		$this->media = new Media();

		$this->media->title 			= Input::get('title');
		$this->media->description = Input::get('description');
		$this->media->category 		= Input::get('category');
		$this->media->keywords 		= Input::get('keywords');
		$this->media->file				= Input::file('file');
		$this->media->authorid 		= Auth::user()->getAuthIdentifier();

		if ($this->media->save()) {
			return Redirect::route('media', array('id' => $this->media->getID()));
		} else {
			$data = array('errors' => $this->media->errors);
			return Redirect::route('new_media')->with($data)->withInput();
		}
	}

	public function download($id) {
		if(Auth::check()) {
			Interaction::logUserDownloadedMedia(Auth::user()->getAuthIdentifier(), $this->media->getID());
		}

		return Response::download($this->media->getFullFilename(), $this->media->getDownloadFilename());
	}

	public function favorite($id) {
		if(Auth::check()) {
			Interaction::logUserFavoritedMedia(Auth::user()->getAuthIdentifier(), $this->media->getID());
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