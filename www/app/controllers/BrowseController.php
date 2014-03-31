<?php

class BrowseController extends BaseController {
	protected $layout = 'browse';

	public function index($category, $page)
	{
			$this->layout->with('category', $category);
			$this->layout->with('page', $page);
			$this->layout->content = View::make('includes.common');
	}
}