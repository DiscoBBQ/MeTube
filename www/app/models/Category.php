<?php

class Category{
  static private $categoriesList = array(
    'music' => 'Music',
    'sports' => 'Sports',
    'gaming' => 'Gaming',
    'education' => 'Education',
    'movies' => 'Movies',
    'tv' => 'TV Shows',
  );

  public static function getAllCategories(){
    return self::$categoriesList;
  }

}

?>