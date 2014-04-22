<?php

class FileConverter{
  static private $image_formats = array("png", "jpeg", "jpg", "gif", "bmp", 'tiff');
  static private $audio_formats = array("m4a", "m4b", "m4p", "mp3", "aiff", "au", "wav", "wma", "ogg");
  static private $video_formats = array("mov", "mp4", "m4v", "avi", "wmv", "ogv", "flv");

  static private $converted_video_extension = "mp4";
  static private $converted_audio_extension = "mp3";

  public static function ConvertFileBasedOnID($file, $id){
    $extension = $file->getClientOriginalExtension();
    if(self::isImage($extension)){
      return self::saveImageFile($file, $id);
    }

    if(self::isAudio($extension)){
      return self::convertAudioFile($file, $id);
    }

    if(self::isVideo($extension)){
      return self::convertVideoFile($file, $id);
    }
  }


  public static function getFinalExtensionForFile($file){
    $extension = strtolower($file->getClientOriginalExtension());
    if(self::isImage($extension)){
      return strtolower($file->getClientOriginalExtension());
    }

    if(self::isAudio($extension)){
      return self::$converted_audio_extension;
    }

    if(self::isVideo($extension)){
      return self::$converted_video_extension;
    }
  }


  protected static function saveImageFile($file, $id){
    $filename = $id . '.' . strtolower($file->getClientOriginalExtension());
    $file->move(self::getBasePath(), $filename);
  }

  protected static function convertAudioFile($file, $id){
    $inputFile = $file->getRealPath();
    $outputFile = self::getBasePath() . $id . "." . self::$converted_audio_extension;
    $arguments = "-y -strict experimental";

    self::callFFMPEG($inputFile, $outputFile, $arguments);
  }

  protected static function convertVideoFile($file, $id){
    $inputFile = $file->getRealPath();
    $outputFile = self::getBasePath() . $id . "." . self::$converted_video_extension;
    $arguments = "-i_qfactor 0.71 -qcomp 0.6 -qmin 10 -qmax 63 -qdiff 4 -trellis 0 -vcodec libx264 -b:v 1000k -b:a 56k -ar 22050 -y";

    self::callFFMPEG($inputFile, $outputFile, $arguments);

    return;
  }

  protected static function callFFMPEG($inputFile, $outputFile, $arguments){
    $ffmpeg_location = exec("which ffmpeg", $command_results); //find the location of ffmpeg

    //if we couldn't find ffmpeg, how can we convert?
    if($ffmpeg_location == ""){
      throw new Exception("ffmpeg is not installed on this server!", 1);
    }

    $errors = array();
    $command = $ffmpeg_location . " -i " . escapeshellarg($inputFile) . " " . $arguments  . "  " . escapeshellarg($outputFile);
    exec($command, $errors);

    if(count($errors) > 0){
      throw new Exception("Could not convert! Error:" . implode("\n", $command_results) , 1);
    }
  }

  public static function isVideo($extension){
    $extension = strtolower($extension);
    foreach (self::$video_formats as $format) {
      if ($extension == strtolower($format)) {
        return true;
      }
    }

    return false;
  }

  public static function isAudio($extension){
    $extension = strtolower($extension);
    foreach (self::$audio_formats as $format) {
      if ($extension == strtolower($format)) {
        return true;
      }
    }

    return false;
  }

  public static function isImage($extension){
    $extension = strtolower($extension);
    foreach (self::$image_formats as $format) {
      if ($extension == strtolower($format)) {
        return true;
      }
    }

    return false;
  }

  protected static function getBasePath(){
    return Config::get('app.file_upload_path') . "/";
  }
}

?>