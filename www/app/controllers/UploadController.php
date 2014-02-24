<?php

class UploadController extends BaseController {
	protected $layout = 'upload';

	public function index()
	{
		$this->layout->content = View::make('includes.common');
	}
}