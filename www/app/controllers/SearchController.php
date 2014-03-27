<?php

class SearchController extends BaseController {
	protected $layout = 'search';

	public function index($phrase, $page)
	{
		$this->layout->with('phrase', $phrase);
		$this->layout->with('page', $page);
		$this->layout->content = View::make('includes.common');
	}

	public function search() {
		return Redirect::to('/search/'.Input::get('phrase').'/1');
	}
}