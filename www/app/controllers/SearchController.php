<?php

class SearchController extends BaseController {
	protected $layout = 'application';

	public function index($phrase)
	{
		$medias = Media::getMediaByKeywordSearch($phrase);
		$data = array('medias' => $medias);
		$this->layout->content = View::make('search.show')->with($data);
	}

	public function search() {
		return Redirect::route('search', array('phrase' =>Input::get('phrase') ));
	}
}