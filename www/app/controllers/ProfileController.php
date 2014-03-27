<?php

class ProfileController extends BaseController {
	protected $layout = 'profile';

	public function index($id)
	{
			$this->layout->with('id', $id);
			$this->layout->content = View::make('includes.common');
	}
}