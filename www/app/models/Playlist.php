<?php

class Playlist{
  public $user_id;
  public $title;
  public $description;
  protected $id;
  public $items = array();
  public $errors = array();

  public function save(){
    if($this->validate() == false){
      return false;
    }

    if($this->id == NULL){
      //insert the record into the DB
      DB::statement("INSERT INTO playlist (user_id, title, description) VALUES (?,?,?)", array($this->user_id, $this->title, $this->description));
      //get the ID of the last inserted record
      $this->id = intval(DB::getPdo()->lastInsertId('id'));
    } else{
      //update the existing record in the DB
      DB::statement("UPDATE playlist SET user_id = ?, title = ?, description = ? WHERE id = ?", array($this->user_id, $this->title, $this->description, $this->id));
    }

    //now that the playlist has been created, save the items associated with it!
    $this->saveItems();
    return true;
  }

  protected function saveItems(){
    //if the playlist already exists, then we need to delete all items associated with the playlist
    //before we re-add them in the new order
    if($this->id != NULL){
      $this->destroyPlaylistItems();
    }

    //loop through every item in the items array, inserting them into the DB
    for ($i=0; $i < count($this->items) ; $i++) {
      $media_id = $this->items[$i];
      DB::statement("INSERT INTO playlist_item (media_id, playlist_id, item_order) VALUES(?,?,?)", array($media_id, $this->id, $i + 1));
    }
  }

  public function destroy(){
    DB::statement("DELETE FROM playlist WHERE id = ?", array($this->id));
    $this->destroyPlaylistItems();
  }

  protected function destroyPlaylistItems(){
    DB::statement("DELETE FROM playlist_item WHERE playlist_id = ?", array($this->id));
  }

  public function getID(){
    return $this->id;
  }

  public function getOwner(){
    return User::getByID($this->user_id);
  }

  static public function deleteAllPlaylistItemsForMedia($media_id){
    DB::statement("DELETE FROM playlist_item WHERE media_id = ?", array($media_id));
  }


  static public function getByID($id){
    $result = DB::select("SELECT * FROM playlist WHERE ID = ? LIMIT 1", array($id));
    if(count($result) == 0){
      return NULL;
    }
    return self::buildPlaylistFromResult($result[0]);
  }

  static public function getAllPlaylistsForUserID($user_id){
    $results = DB::select("SELECT * FROM playlist WHERE user_id = ? ORDER BY id", array($user_id));

    $playlists = array();

    foreach ($results as $result) {
      array_push($playlists, self::buildPlaylistFromResult($result));
    }

    return $playlists;
  }

  static protected function buildPlaylistFromResult($result){
    $playlist = new self();
    if($result == NULL){
      return NULL;
    }

    $playlist->id               = intval($result->id);
    $playlist->title            = $result->title;
    $playlist->description      = $result->description;
    $playlist->user_id          = intval($result->user_id);

    $playlist_items_results = DB::select("SELECT media_id FROM playlist_item WHERE playlist_id = ? ORDER BY item_order", array($playlist->id));

    //Now get all the items associated with this playlist
    foreach ($playlist_items_results as $playlist_item_result) {
      $playlist->addMediaToPlaylist($playlist_item_result->media_id);
    }

    return $playlist;
  }

  public function addMediaToPlaylist($media_id){
    $media_id = intval($media_id);
    //Only add the media to the playlist if it exists
    if(Media::getByID($media_id) == NULL){
      return;
    }

    foreach ($this->items as $playlist_items) {
      //Does this item already exist in the playlist? If yes, then don't add it again.
      if($playlist_items == $media_id){
        return;
      }
    }

    //doesn't exist, so add the item to the array
    array_push($this->items, $media_id);
  }

  public function removeMediaFromPlaylist($media_id){
    $media_id = intval($media_id);
    $i = 0;
    while($i < count($this->items)){
      if($this->items[$i] == $media_id){
        break;
      }
      $i++;
    }

    //if we reached the end of the items and didn't find this item, them don't try to remove it.
    if($i == count($this->items)){
      return;
    }

    array_splice($this->items, $i, 1);
  }

  public function movePlaylistItemUp($index){
    $this->swapItems($index - 1, $index);
  }

  public function movePlaylistItemDown($index){
    $this->swapItems($index, $index + 1);
  }

  protected function swapItems($index_a, $index_b){
    if(($index_a < 0 || $index_b < 0) || ($index_a >= count($this->items) || $index_b >= count($this->items))){
      return;
    }

    $temp = $this->items[$index_a];
    $this->items[$index_a] = $this->items[$index_b];
    $this->items[$index_b] = $temp;
  }

  protected function sanitizeData(){
    $this->title = stripslashes(trim($this->title));
    $this->description = stripslashes(trim($this->description));
  }

  protected function isTitleTakenForUser(){
    if($this->id == NULL){
      $result = DB::select("SELECT COUNT(*) AS count FROM playlist WHERE title = ? AND user_id = ?", array($this->title, $this->user_id));
    } else{
      $result = DB::select("SELECT COUNT(*) AS count FROM playlist WHERE title = ? AND user_id = ? AND id  != ?", array($this->title, $this->user_id, $this->id));
    }
    return intval($result[0]->count) > 0;
  }

  public function validate(){
    $this->sanitizeData();

    if($this->title === ""){
      $this->errors["title"] = "Title cannot be blank";
    }

    if($this->isTitleTakenForUser()){
      $this->errors["title"] = "You already have a playlist with that title";
    }

    if($this->description === ""){
      $this->errors["description"] = "Description cannot be blank";
    }


    if(User::getByID($this->user_id) == NULL){
      $this->errors["user_id"] = "User does not exist";
    }

    if(count($this->errors) > 0){
      return false;
    } else{
      return true;
    }
  }

}

?>