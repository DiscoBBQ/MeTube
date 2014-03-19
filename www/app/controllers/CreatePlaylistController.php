<?php

class CreatePlaylistController extends BaseController {
	protected $layout = 'create_playlist';

	public function index()
	{
		if(Auth::check())
			$this->layout->content = View::make('includes.common');
		else
			return Redirect::to('/signin');
	}

	public function create() {
		echo Input::get('description');


		$result = DB::select("SELECT * FROM playlist WHERE user_id = ? AND title = ?", array(Auth::user()->id, Input::get('title')));
				
		if (sizeof($result) == 0) {
			$id = DB::table('playlist')->insertGetId(array('user_id' => Auth::user()->id,
										 'title' => Input::get('title'),
										 'description' => Input::get('description')));

			return Redirect::to('/playlist/'.$id.'/1');
		} else {
			return Redirect::to('/createplaylist');
		}
	}
}