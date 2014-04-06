<?php

class Interaction{

  static public function getDownloadedString(){
    return 'downloaded';
  }

  static public function getFavoritedString(){
    return 'favorited';
  }

  static public function getViewedString(){
    return 'viewed';
  }

  static public function deleteAllInteractionsForMedia($media_id){
    DB::statement("DELETE FROM interactions WHERE media_id = ?", array($media_id));
  }

  static public function deleteAllInteractionsForUser($user_id){
    DB::statement("DELETE FROM interactions WHERE user_id = ?", array($user_id));
  }

  static public function logUserDownloadedMedia($user_id, $media_id){
    self::logInteractionForUserAndMediaByCategory($user_id, $media_id, self::getDownloadedString());
  }

  static public function logUserFavoritedMedia($user_id, $media_id){
    self::logInteractionForUserAndMediaByCategory($user_id, $media_id, self::getFavoritedString());
  }

  static public function logUserViewedMedia($user_id, $media_id){
    self::logInteractionForUserAndMediaByCategory($user_id, $media_id, self::getViewedString());
  }

  static protected function logInteractionForUserAndMediaByCategory($user_id, $media_id, $category){
    $count = DB::select("SELECT COUNT(*) AS count FROM interactions WHERE user_id = ? AND media_id = ? AND category = ?", array($user_id, $media_id, $category));

    if($count[0]->count <= 0){
      DB::statement("INSERT INTO interactions (user_id, media_id, category) VALUES (?,?,?)", array($user_id, $media_id, $category));
    }
  }

}

?>