<?php

class MeTubeController extends BaseController {
	protected $layout = 'application';

	public function index()
	{
		$this->layout->content = View::make('metube.index');
	}
}