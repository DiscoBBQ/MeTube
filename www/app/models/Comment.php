<?php

class Comment{
  public $user_id;
  public $media_id;
  public $comment;
  protected $id;
  public $errors = array();
  protected $created_at;

  public function save(){
    if($this->validate() == false){
      return false;
    }

    if($this->id == NULL){
      //insert the record into the DB
      DB::statement("INSERT INTO comments (user_id, media_id, comment) VALUES (?,?,?)", array($this->user_id, $this->media_id, $this->comment));
      //get the ID of the last inserted record
      $this->id = intval(DB::getPdo()->lastInsertId('id'));
      return true;
    } else{
      //update the existing record in the DB
      DB::statement("UPDATE comments SET user_id = ?, media_id = ?, comment = ?, to_user_id = ? WHERE id = ?", array($this->user_id, $this->media_id, $this->comment, $this->id));
      return true;
    }
  }

  public function getID(){
    return $this->id;
  }

  public function getCommentor(){
    return User::getByID($this->user_id);
  }

  public function getMedia(){
    return Media::getByID($this->media_id);
  }

  public function getCreatedAt(){
    return $this->created_at;
  }

  static public function deleteAllCommentsForMedia($media_id){
    DB::statement("DELETE FROM comments WHERE media_id = ?", array($media_id));
  }

  static public function deleteAllCommentsForUser($media_id){
    DB::statement("DELETE FROM comments WHERE media_id = ?", array($media_id));
  }

  static public function getByID($id){
    $result = DB::select("SELECT * FROM comments WHERE ID = ? LIMIT 1", array($id));
    if(count($result) == 0){
      return NULL;
    }
    return self::buildCommentFromResult($result[0]);
  }

  static public function getAllCommentsForUser($user_id){
    $results = DB::select("SELECT * FROM comments WHERE user_id = ? ORDER BY id DESC", array($user_id));
    $comments = array();

    foreach ($results as $result) {
      array_push($comments, self::buildCommentFromResult($result));
    }

    return $comments;
  }

  static public function getAllCommentsForMedia($media_id){
    $results = DB::select("SELECT * FROM comments WHERE media_id = ? ORDER BY id DESC", array($media_id));
    $comments = array();

    foreach ($results as $result) {
      array_push($comments, self::buildCommentFromResult($result));
    }

    return $comments;
  }

  static protected function buildCommentFromResult($result){
    $comment = new self();
    if($result == NULL){
      return NULL;
    } else{
      $comment->id               = intval($result->id);
      $comment->user_id          = intval($result->user_id);
      $comment->media_id         = intval($result->media_id);
      $comment->comment          = $result->comment;
      $comment->created_at       = new DateTime($result->created_at);
    }

    return $comment;
  }

  protected function sanitizeData(){
    $this->comment =  stripslashes(trim($this->comment));
  }

  public function validate(){
    $this->sanitizeData();

    if($this->comment === ""){
      $this->errors["comment"] = "Comment cannot be blank";
    }

    if(User::getByID($this->user_id) == NULL){
      $this->errors["user_id"] = "Commentor does not exist";
    }

    if(Media::getByID($this->media_id) == NULL){
      $this->errors["media_id"] = "Media does not exist";
    }

    if(count($this->errors) > 0){
      return false;
    } else{
      return true;
    }
  }



}

?>