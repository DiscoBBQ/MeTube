<?php

class UserController extends BaseController {
	protected $layout = 'application';

	public function create()
	{
    $user = new User();
    $user->username = Input::get('username');
    $user->password = Input::get('password');
    $user->passwordConfirmation = Input::get('password_confirm');
		if($user->save()){
      //login the newly created user automatically
      Auth::attempt(array('username' => $user->username, 'password' => $user->password), true);
      return Redirect::to('/');
    } else{
      return Redirect::to('/register');
    }
	}

  public function show($id){
    $user = User::getById($id);
    if($user == NULL){
      App:abort(404);
    }

    $this->layout->content = View::make('users.show')->with(array('user' => $user));
  }
}