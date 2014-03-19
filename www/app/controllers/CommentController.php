<?php

class CommentController extends BaseController {
	public function create($id) {
		if(Auth::check()) {
			DB::statement("INSERT INTO comments (user_id, media_id, comment) VALUES (?,?,?)", array(Auth::user()->id, $id, Input::get('comment')));

			return Redirect::to('/media/'.$id);
		}
		else {
			return Redirect::to('/signin');
		}
	}
}