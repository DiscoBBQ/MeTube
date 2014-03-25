<?php

class UserController extends BaseController {
  protected $layout = 'channel';
  protected $user;

   public function __construct()
    {
        $this->beforeFilter('@find_user_by_ID_or_raise_404', array('only' => array('show', 'edit', 'update')));
        $this->beforeFilter('@authed_user_matches_this_user', array('only' => array('edit', 'update')));
    }

  public function create()
  {
    $this->user = new User();
    $this->user->username = Input::get('username');
    $this->user->password = Input::get('password');
    $this->user->passwordConfirmation = Input::get('password_confirm');
    if($this->user->save()){
      //login the newly created user automatically
      Auth::attempt(array('username' => $this->user->username, 'password' => $this->user->password), true);
      return Redirect::to('/');
    } else{
      return Redirect::to('/register');
    }
  }

  public function show(){
    return View::make('users/show', array('user' => $this->user));
  }

  public function edit(){
    return View::make('users/edit', array('user' => $this->user));
  }

  public function update(){
    $this->user->username = Input::get('username');
    $this->user->password = Input::get('password');
    $this->user->passwordConfirmation = Input::get('password_confirm');
    if($this->user->save()){
      //login the newly created user automatically
      Auth::attempt(array('username' => $this->user->username, 'password' => $this->user->password), true);
      return Redirect::to('user_show');
    } else{
      return Redirect::to('profile_edit');
    }
  }

  public function find_user_by_ID_or_raise_404(){
    $this->user = User::getByID(Route::input('id'));
    if($this->user == NULL){
      App::abort(404);
    }
  }

  public function authed_user_matches_this_user(){
    if(Auth::user()->getAuthIdentifier() != $this->user->getAuthIdentifier()){
      return Redirect::to('/');
    }
  }
}