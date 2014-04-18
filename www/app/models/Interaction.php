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

  static public function countDownloadedForMedia($media_id){
    return self::countInteractionsForMediaAndCategory($media_id, self::getDownloadedString());
  }

  static public function countFavoritedForMedia($media_id){
    return self::countInteractionsForMediaAndCategory($media_id, self::getFavoritedString());
  }

  static public function countViewedForMedia($media_id){
    return self::countInteractionsForMediaAndCategory($media_id, self::getViewedString());
  }

  static protected function countInteractionsForMediaAndCategory($media_id, $category){
    $count = DB::select("SELECT SUM(count) as count FROM interactions WHERE category=? AND media_id = ?", array($category, $media_id));
    if($count[0]->count == NULL){
      return 0;
    }
    return $count[0]->count;
  }

  static protected function logInteractionForUserAndMediaByCategory($user_id, $media_id, $category){
    if($user_id == NULL){
      $count = DB::select("SELECT COUNT(*) AS count FROM interactions WHERE user_id IS NULL AND media_id = ? AND category = ?", array($media_id, $category));
    } else{
      $count = DB::select("SELECT COUNT(*) AS count FROM interactions WHERE user_id = ? AND media_id = ? AND category = ?", array($user_id, $media_id, $category));
    }

    if($count[0]->count <= 0){
      DB::statement("INSERT INTO interactions (user_id, media_id, category) VALUES (?,?,?)", array($user_id, $media_id, $category));
    } else{
      if($user_id == NULL){
        DB::statement("UPDATE interactions SET count = count + 1 WHERE user_id IS NULL AND media_id = ? AND category = ?", array($media_id, $category));
      } else{
        DB::statement("UPDATE interactions SET count = count + 1 WHERE user_id = ? AND media_id = ? AND category = ?", array($user_id, $media_id, $category));
      }
    }
  }

}

?>