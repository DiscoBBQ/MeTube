<?php

class UserController extends BaseController {
	protected $layout = 'channel';

	public function create()
	{
    Xdebug_break();
    $user = new User();
    $user->username = Input::get('username');
    $user->password = Input::get('password');
    $user->passwordConfirmation = Input::get('password_confirm');
		if($user->save()){
      return Redirect::to('/');
    } else{
      return Redirect::to('/register');
    }
	}
}