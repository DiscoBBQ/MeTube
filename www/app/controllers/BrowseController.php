<?php

class BrowseController extends BaseController {
	protected $layout = 'application';

	public function browseCategory($category, $page)
	{
    $results = DB::select('select media.id from media where category = ? order by id desc', array($category));
    $count = sizeof($results);
    $results = array_slice($results, ($page - 1), 6);
    $pagination_params = array('category' => $category);
    $route_name = 'browse_category';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
		$this->layout->content = View::make('browse.media-list')->with($data);
	}

  public function browseDownloaded($userid, $page)
  {
    $results = DB::select("SELECT media.id FROM interactions,media WHERE user_id = ? AND interactions.category = 'downloaded' AND authorid = user_id AND media_id = id ORDER BY created_on desc", array($userid));
    $count = sizeof($results);
    $results = array_slice($results, ($page - 1), 6);
    $pagination_params = array('userid' => $userid);
    $route_name = 'downloaded';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseFavorited($userid, $page)
  {
    $results = DB::select("SELECT media.id FROM interactions,media WHERE user_id = ? AND interactions.category = 'favorited' AND authorid = user_id AND media_id = id ORDER BY created_on desc", array($userid));
    $count = sizeof($results);
    $results = array_slice($results, ($page - 1), 6);
    $pagination_params = array('userid' => $userid);
    $route_name = 'favorited';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseViewed($userid, $page)
  {
    $results = DB::select("SELECT media.id FROM interactions,media WHERE user_id = ? AND interactions.category = 'viewed' AND authorid = user_id AND media_id = id ORDER BY created_on desc", array($userid));
    $count = sizeof($results);
    $results = array_slice($results, ($page - 1), 6);
    $pagination_params = array('userid' => $userid);
    $route_name = 'viewed';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseUploaded($userid, $page)
  {
    $results = DB::select('SELECT media.id FROM media WHERE authorid = ? ORDER BY created_on desc', array($userid));
    $count = sizeof($results);
    $results = array_slice($results, ($page - 1), 6);
    $pagination_params = array('userid' => $userid);
    $route_name = 'uploaded';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

}