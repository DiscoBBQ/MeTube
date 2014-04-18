<?php

class UserController extends BaseController {
	protected $layout = 'application';
  protected $user;

  public function __construct()
  {
    $this->beforeFilter('@find_user_by_ID_or_raise_404', array('only' => array('show')));
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
      return Redirect::route('register')->with($data)->withInput();
    }
	}

  public function show($id){
    $this->layout->content = View::make('users.show')->with(array('user' => $this->user));
  }

  public function edit(){
    $this->user = User::getByID(Auth::user()->getAuthIdentifier());
    $error_messages = Session::get('errors');
    $data = array('user' => $this->user,'error_messages' => $error_messages);
    $this->layout->content = View::make('users.edit')->with($data);
  }

  public function update() {
    $this->user = User::getByID(Auth::user()->getAuthIdentifier());
    $this->user->email = Input::get('email');
    $this->user->channel_name = Input::get('channel_name');
    //only add the password fields if they have a real value (not an empty string)
    if(Input::get('current_password') != ""){
      $this->user->current_password = Input::get('current_password');
    }

    if(Input::get('password') != ""){
      $this->user->password = Input::get('password');
    }

    if(Input::get('password_confirm') != ""){
      $this->user->passwordConfirmation = Input::get('password_confirm');
    }

    if($this->user->save()){
      return Redirect::route('profile', array('id' => $this->user->getID()));
    } else{
      $data = array('errors' => $this->user->errors);
      return Redirect::route('edit_profile')->with($data)->withInput();
    }
  }

  public function find_user_by_ID_or_raise_404(){
    $this->user = User::getById(Route::input('id'));
    if($this->user == NULL){
      App:abort(404);
    }
  }
}