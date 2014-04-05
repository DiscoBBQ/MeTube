<?php

class AuthenticationController extends BaseController {
	protected $layout = 'application';

	public function authenticate()
	{
    $email = Input::get('email');
    $password = Input::get('password');
    if(Auth::attempt(array('email' => $email, 'password' => $password), true)){
      return Redirect::route('home');
    } else{
      return Redirect::route('signin');
    }
	}

  public function logout(){
    Auth::logout();
    return Redirect::route('home');
  }
}