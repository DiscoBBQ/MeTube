<?php

class MessageController extends BaseController {
  protected $layout = 'application';

  protected $message;

  public function __construct()
  {
    $this->beforeFilter('@find_message_by_ID_or_raise_404', array('only' => array('show')));
    $this->beforeFilter('@authed_user_matches_sender_or_recipient', array('only' => array('show')));
  }

  public function newMessage(){
    $to_user_field = array();
    foreach (User::getAll() as $user) {
      $to_user_field[$user->getID()] = $user->channel_name;
    }

    $error_messages = Session::get('errors');

    $data = array('to_user_field' => $to_user_field, 'error_messages' => $error_messages);
    $this->layout->content = View::make('message.new')->with($data);
  }

  public function show($id)
  {
    $this->layout->content = View::make('message.show')->with(array('message' => $this->message));
  }

  public function create() {
    $this->message = new Message();

    $this->message->subject = Input::get('subject');
    $this->message->message = Input::get('message');
    $this->message->to_user_id = Input::get('to_user_id');
    $this->message->from_user_id = Auth::user()->getAuthIdentifier();

    if($this->message->save()){
      return Redirect::route('message', array('id' => $this->message->getID()));
    } else{
      $data = array('errors' => $this->message->errors);
      return Redirect::route('new_message')->with($data);
    }
  }

  public function index(){
    $messages = Message::getAllMessagesSentToUser(Auth::user()->getAuthIdentifier());
    $this->layout->content = View::make('message.index')->with(array('messages' => $messages));
  }

  public function sent(){
    $messages = Message::getAllMessagesSentFromUser(Auth::user()->getAuthIdentifier());
    $this->layout->content = View::make('message.sent')->with(array('messages' => $messages));
  }

  public function find_message_by_ID_or_raise_404(){
    $this->message = Message::getByID(Route::input('id'));
    if($this->message == NULL){
      App::abort(404);
    }
  }

  public function authed_user_matches_sender_or_recipient(){
    $sender_id    = $this->message->from_user_id;
    $recipient_id = $this->message->to_user_id;
    if((Auth::user()->getAuthIdentifier() != $sender_id) && (Auth::user()->getAuthIdentifier() != $recipient_id)){
      return Redirect::route('home');
    }
  }
}