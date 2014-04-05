<?php

class Message {

  public $subject;
  public $message;
  public $from_user_id;
  public $to_user_id;
  protected $id;
  public $errors = array();

  public function save(){
    if($this->validate() == false){
      return false;
    }

    if($this->id == NULL){
      //insert the record into the DB
      DB::statement("INSERT INTO messages (subject, message, from_user_id, to_user_id) VALUES (?,?,?,?)", array($this->subject, $this->message, $this->from_user_id, $this->to_user_id));
      //get the ID of the last inserted record
      $this->id = intval(DB::getPdo()->lastInsertId('id'));
      return true;
    } else{
      //update the existing record in the DB
      DB::statement("UPDATE messages SET subject = ?, message = ?, from_user_id = ?, to_user_id = ? WHERE id = ?", array($this->subject, $this->message, $this->from_user_id, $this->to_user_id, $this->id));
      return true;
    }
  }

  public function getID(){
    return $this->id;
  }

  public function getSender(){
    return User::getByID($this->from_user_id);
  }

  public function getRecipient(){
    return User::getByID($this->to_user_id);
  }

  static public function getByID($id){
    $result = DB::select("SELECT * FROM messages WHERE ID = ? LIMIT 1", array($id));
    if(count($result) == 0){
      return NULL;
    }
    return self::buildMessageFromResult($result[0]);
  }

  static public function getAllMessagesSentFromUser($user_id){
    $results = DB::select("SELECT * FROM messages WHERE from_user_id = ? ORDER BY id DESC", array($user_id));

    $messages = array();

    foreach ($results as $result) {
      array_push($messages, self::buildMessageFromResult($result));
    }

    return $messages;
  }

  static public function getAllMessagesSentToUser($user_id){
    $results = DB::select("SELECT * FROM messages WHERE to_user_id = ? ORDER BY id DESC", array($user_id));

    $messages = array();

    foreach ($results as $result) {
      array_push($messages, self::buildMessageFromResult($result));
    }

    return $messages;
  }

  static protected function buildMessageFromResult($result){
    $message = new self();
    if($result == NULL){
      return NULL;
    } else{
      $message->id               = intval($result->id);
      $message->subject          = $result->subject;
      $message->message          = $result->message;
      $message->from_user_id     = $result->from_user_id;
      $message->to_user_id       = $result->to_user_id;
    }

    return $message;
  }

  protected function sanitizeData(){
    $this->subject = trim($this->subject);
    $this->message = trim($this->message);
  }

  public function validate(){
    $this->sanitizeData();

    if($this->subject === ""){
      $this->errors["subject"] = "Subject cannot be blank";
    }

    if($this->message === ""){
      $this->errors["message"] = "Message cannot be blank";
    }


    if(User::getByID($this->from_user_id) == NULL){
      $this->errors["from_user_id"] = "Sender does not exist";
    }

    if(User::getByID($this->to_user_id) == NULL){
      $this->errors["to_user_id"] = "Recipient does not exist";
    }

    if(count($this->errors) > 0){
      return false;
    } else{
      return true;
    }
  }
}