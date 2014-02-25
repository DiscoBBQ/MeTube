<?php

class ChannelController extends BaseController {
	protected $layout = 'channel';

	public function index()
	{
		$this->layout->content = View::make('includes.common');
	}
}