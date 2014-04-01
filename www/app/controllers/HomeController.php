<?php

class HomeController extends BaseController {
	protected $layout = 'application';

	public function index()
	{
		$this->layout->content = View::make('home.index');
	}
}