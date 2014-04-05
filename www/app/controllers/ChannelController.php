<?php

class ChannelController extends BaseController {
	protected $layout = 'application';

	public function show($id, $page)
	{
    $results = DB::select('SELECT media.id FROM media,subscriptions WHERE authorid = subscription_user_id AND subscribing_user_id = ? ORDER BY created_on DESC', array($id));
    $count = sizeof($results);
    $results = array_slice($results, ($page - 1), 6);
    $pagination_params = array('id' => $id);
    $route_name = 'channel';
    $data = array('results' => $results, 'current_page' => $page, 'pagination_params' => $pagination_params, 'count' => $count, 'route_name' => $route_name);
    $this->layout->content = View::make('channel.show')->with($data);
	}
}