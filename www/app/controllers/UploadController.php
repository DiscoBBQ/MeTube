<?php

class UploadController extends BaseController {
	protected $layout = 'upload';

	public function index()
	{
		if(Auth::check())
			$this->layout->content = View::make('includes.common');
		else
			return Redirect::to('/signin');
	}
}