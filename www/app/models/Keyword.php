<?php

class Keyword{
  static public function createKeywordsForMediaFromPhrase($media_id, $phrase){
    $keywords = self::makeKeywordsArrayFromPhrase($phrase);

    foreach($keywords as $keyword) {
      self::createKeywordForMediaIfDoesntExist($media_id, $keyword);
    }
  }

  static public function makeKeywordsArrayFromPhrase($phrase){
    $keywords =  array_unique(preg_split("/[\s,;]+/", $phrase));

    for ($i=0; $i < count($keywords) ; $i++) { 
      $keywords[$i] = stripslashes(trim(strtolower($keywords[$i])));
    }

    return $keywords;
  }

  static public function deleteAllKeywordsForMedia($media_id){
    DB::statement("DELETE FROM keywords WHERE mediaid = ?", array($media_id));
  }

  static public function getKeywordStringForMediaAndItsTitle($media_id, $title){
    $results = DB::select("SELECT keyword FROM keywords WHERE mediaid = ?", array($media_id));

    $keywords = array();
    foreach($results as $result) {
      array_push($keywords, $result->keyword);
    }

    $titlewords = array();
    foreach(explode(' ', $title) as $titleword) {
      array_push($titlewords, $titleword);
    }

    $keywords = array_diff($keywords, $titlewords);

    return implode(' ', $keywords);
  }

  static protected function createKeywordForMediaIfDoesntExist($media_id, $keyword){
    $count = DB::select("SELECT COUNT(*) AS count FROM keywords WHERE mediaid = ? AND keyword = ?", array($media_id, $keyword));

    if($count[0]->count <= 0){
      DB::statement("INSERT INTO keywords (mediaid, keyword) VALUES (?,LOWER(?))", array($media_id, $keyword));
    }
  }
}

?>