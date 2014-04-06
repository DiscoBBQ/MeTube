<?php

class SearchController extends BaseController {
	protected $layout = 'application';

	public function index($phrase)
	{
		$keywords = explode(' ', $phrase);
		$results = DB::select("SELECT media.id, mediaid FROM keywords,media WHERE media.id = keywords.mediaid AND keywords.keyword IN(?) GROUP BY mediaid ORDER BY COUNT(*) desc", $keywords);
    $data = array('results' => $results);
		$this->layout->content = View::make('search.show')->with($data);
	}

	public function search() {
		return Redirect::route('search', array('phrase' =>Input::get('phrase') ));
	}
}