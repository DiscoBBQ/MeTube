<?php

class SearchController extends BaseController {
	protected $layout = 'application';

	public function index($phrase, $page)
	{
		$keywords = explode(' ', $phrase);
		$results = DB::select("SELECT media.id, mediaid FROM keywords,media WHERE media.id = keywords.mediaid AND keywords.keyword IN(?) GROUP BY mediaid ORDER BY COUNT(*) desc", $keywords);

		$count = sizeof($results);
		$results = array_slice($results, ($page - 1), 6);
		$pagination_params = array('phrase' => $phrase);
    $route_name = 'search';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
		$this->layout->content = View::make('search.show')->with($data);
	}

	public function search() {
		return Redirect::route('search', array('phrase' =>Input::get('phrase'), 'page' => 1 ));
	}
}