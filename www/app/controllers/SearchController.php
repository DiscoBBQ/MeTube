<?php

class SearchController extends BaseController {
	protected $layout = 'search';

	public function index()
	{
		$this->layout->content = View::make('includes.common');
	}
}