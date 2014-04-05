<?php

class AuthenticationController extends BaseController {
	protected $layout = 'application';

	public function authenticate()
	{
    $channel_name = Input::get('channel_name');
    $password = Input::get('password');
    if(Auth::attempt(array('channel_name' => $channel_name, 'password' => $password), true)){
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