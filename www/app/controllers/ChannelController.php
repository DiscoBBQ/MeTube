<?php

class ChannelController extends BaseController {
	protected $layout = 'channel';

	public function index($id, $page)
	{
			$this->layout->with('id', $id);
			$this->layout->with('page', $page);
			$this->layout->content = View::make('includes.common');
	}
}