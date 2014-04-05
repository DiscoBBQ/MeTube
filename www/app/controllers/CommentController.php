<?php

class CommentController extends BaseController {
	public function create($id) {
		DB::statement("INSERT INTO comments (user_id, media_id, comment) VALUES (?,?,?)", array(Auth::user()->id, $id, Input::get('comment')));
		return Redirect::to('media', array('id' => $id));
	}
}