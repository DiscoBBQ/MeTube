<?php

class UserController extends BaseController {
	protected $layout = 'application';
  protected $user;

  public function __construct()
  {
    $this->beforeFilter('@find_user_by_ID_or_raise_404', array('only' => array('show')));
    // $this->beforeFilter('@authed_user_matches_sender_or_recipient', array('only' => array('show')));
  }

	public function create()
	{
    $this->user = new User();
    $this->user->email = Input::get('email');
    $this->user->channel_name = Input::get('channel_name');
    $this->user->password = Input::get('password');
    $this->user->passwordConfirmation = Input::get('password_confirm');
		if($this->user->save()){
      //login the newly created user automatically
      Auth::attempt(array('email' => $this->user->email, 'password' => $this->user->password), true);
      return Redirect::route('home');
    } else{
      $data = array('errors' => $this->user->errors);
      return Redirect::route('register')->with($data);
    }
	}

  public function show($id){
    $this->layout->content = View::make('users.show')->with(array('user' => $user));
  }

  public function find_user_by_ID_or_raise_404(){
    $this->user = User::getById($id);
    if($this->user == NULL){
      App:abort(404);
    }
  }
}