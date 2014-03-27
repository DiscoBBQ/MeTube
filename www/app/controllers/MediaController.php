<?php

class MediaController extends BaseController {
	protected $layout = 'media';

	public function index($id)
	{
		$this->layout->with('id', $id);
		$this->layout->content = View::make('includes.common');
	}

	public function upload() {
		$media = new Media(Input::get('title'),
						   Input::get('description'),
						   Input::get('category'),
						   Input::get('keywords'),
						   Input::file('file')->getClientOriginalExtension(),
						   User::getByUsername(Auth::user()->username)->getID());

		$id = $media->save(Input::file('file'));

		if ($id != -1) {
			return Redirect::to('/media/'.$id);
		} else {
			return Redirect::to('/upload')->with('error_messages', 'test');
		}
	}

	public function download($id) {
		$media = Media::getByID($id);

		return Response::download('uploaded_media/'.$id.'.'.$media->getExtension(), $media->getTitle());
	}
}