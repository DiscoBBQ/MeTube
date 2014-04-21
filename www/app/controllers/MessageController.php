<?php

class MessageController extends BaseController {
  protected $layout = 'application';

  protected $message;

  public function __construct()
  {
    $this->beforeFilter('@find_message_by_ID_or_raise_404', array('only' => array('show', 'reply', 'createReply')));
    $this->beforeFilter('@authed_user_matches_sender_or_recipient', array('only' => array('show', 'reply', 'createReply')));
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

  public function reply(){
    $first_subject = "RE: " . $this->message->subject;
    $error_messages = Session::get('errors');
    $data = array('error_messages' => $error_messages, 'first_subject' => $first_subject, 'parent_message' => $this->message);
    $this->layout->content = View::make('message.reply')->with($data);
  }

  public function createReply(){
    $new_message = new Message();

    $new_message->subject = Input::get('subject');
    $new_message->message = Input::get('message');
    $new_message->to_user_id = $this->message->getSender()->getID();
    $new_message->from_user_id = Auth::user()->getAuthIdentifier();
    $new_message->parent_message_id = $this->message->getID();

    if($new_message->save()){
      return Redirect::route('message', array('id' => $new_message->getID()));
    } else{
      $data = array('errors' => $new_message->errors);
      return Redirect::route('message_reply', array('id' => $this->message->getID()))->with($data)->withInput();
    }
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
      return Redirect::route('new_message')->with($data)->withInput();
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