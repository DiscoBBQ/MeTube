<?php

class AuthenticationController extends BaseController {
	protected $layout = 'application';

	public function authenticate()
	{
    $username = Input::get('username');
    $password = Input::get('password');
    if(Auth::attempt(array('username' => $username, 'password' => $password), true)){
      return Redirect::route('home');
    } else{
      return Redirect::to('/signin');
    }
	}

  public function logout(){
    Auth::logout();
    return Redirect::route('home');
  }
}