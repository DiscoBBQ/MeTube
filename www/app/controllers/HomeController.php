<?php

class HomeController extends BaseController {
	protected $layout = 'home';

	public function index()
	{
		$this->layout->content = View::make('includes.common');
	}
}