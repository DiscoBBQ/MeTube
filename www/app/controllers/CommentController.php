<?php

class CommentController extends BaseController {
  protected $comment;

	public function create($id) {
    $this->comment = new Comment();

    $this->comment->user_id = Auth::user()->getAuthIdentifier();
    $this->comment->media_id = $id;
    $this->comment->comment = Input::get('comment');

    if($this->comment->save()){
      return Redirect::route('media', array('id' => $id));
    } else{
      $data = array('errors' => $this->comment->errors);
      return Redirect::route('media', array('id' => $id))->with($data)->withInput();
    }
	}
}