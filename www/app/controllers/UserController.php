<?php

class UserController extends BaseController {
	protected $layout = 'application';

	public function create()
	{
    $user = new User();
    $user->channel_name = Input::get('channel_name');
    $user->password = Input::get('password');
    $user->passwordConfirmation = Input::get('password_confirm');
		if($user->save()){
      //login the newly created user automatically
      Auth::attempt(array('email' => $user->email, 'password' => $user->password), true);
      return Redirect::route('home');
    } else{
      return Redirect::route('register');
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