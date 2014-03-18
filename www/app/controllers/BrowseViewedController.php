<?php

class BrowseViewedController extends BaseController {
	protected $layout = 'browse_viewed';

	public function index($userid, $page)
	{
			$this->layout->with('userid', $userid);
			$this->layout->with('page', $page);
			$this->layout->content = View::make('includes.common');
	}
}