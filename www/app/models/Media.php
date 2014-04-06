<?php

class Media {
	public $title;
	public $description;
	public $category;
	public $keywords;
	public $authorid;
	public $created_on;
	public $extension;
	public $id;

	private $errors = array();

	static private $picture_formats = array("png", "jpeg", "jpg", "gif", "bmp");
	static private $audio_formats = array("m4a", "m4b", "m4p", "mp3", "aiff", "au", "wav");
	static private $qt_video_formats = array("mov", "mp4", "m4v", "avi");
	static private $wmp_video_formats = array("wmv", "wma", "wm");

	function __construct($title, $description, $category, $keywords, $extension, $authorid) {
		$this->title = $title;
		$this->description = $description;
		$this->category = $category;
		$this->keywords = $keywords;
		$this->extension = strtolower($extension);
		$this->authorid = $authorid;

		$this->created_on = date("Y-m-d");
	}

	public function getID() { return $this->id; }
	public function getTitle() { return $this->title; }
	public function getDescription() { return $this->description; }
	public function getCategory() { return $this->category; }
	public function getKeywords() { return $this->keywords; }
	public function getAuthorId() { return $this->authorid; }
	public function getCreatedOn() { return $this->created_on; }
	public function getExtension() { return $this->extension; }
	public function getAuthor() { return  User::getByID($this->authorid); }

	static public function getByID($id){
		$result = DB::select("SELECT * FROM media WHERE id = ? LIMIT 1", array($id));

		if (count($result) == 0) {
			return NULL;
		}

		return self::buildMediaFromResult($result[0]);
	}

	static public function getUploadedByUserID($user_id){
		$results = DB::select('SELECT * FROM media WHERE authorid = ? ORDER BY created_on desc', array($user_id));

		$medias = array();

		foreach ($results as $result) {
			array_push($medias, self::buildMediaFromResult($result));
		}

		return $medias;
	}

	static public function getDownloadedByUserID($user_id){
		return self::getMediaByInteractionAndUserID('downloaded', $user_id);
	}

	static public function getFavoritedByUserID($user_id){
		return self::getMediaByInteractionAndUserID('favorited', $user_id);
	}

	static public function getViewedByUserID($user_id){
		return self::getMediaByInteractionAndUserID('viewed', $user_id);
	}

	static protected function getMediaByInteractionAndUserID($interaction, $user_id){
		$results = DB::select("SELECT media.* FROM interactions,media WHERE interactions.category = ? AND interactions.user_id = ? AND media_id = id ORDER BY created_on desc", array($interaction, $user_id));

		$medias = array();

		foreach ($results as $result) {
			array_push($medias, self::buildMediaFromResult($result));
		}

		return $medias;
	}

	static public function getMediaForPlaylistID($playlist_id){
		$results = DB::select("SELECT media.* FROM media,playlist_item WHERE playlist_id = ? AND id = media_id ORDER BY item_order", array($playlist_id));

		$medias = array();

		foreach ($results as $result) {
			array_push($medias, self::buildMediaFromResult($result));
		}

		return $medias;
	}

	static public function getMediaForCategory($category){
		$results = DB::select('select media.* from media where category = ? order by id desc', array($category));
		$medias = array();

		foreach ($results as $result) {
			array_push($medias, self::buildMediaFromResult($result));
		}

		return $medias;
	}

	static protected function buildMediaFromResult($result){
		if($result == NULL){
			return NULL;
		}

		$keyword_result = DB::select("SELECT keyword FROM keywords WHERE mediaid = ?", array($result->id));

		$keywords = array();
		foreach($keyword_result as $keyword) {
			array_push($keywords, $keyword->keyword);
		}

		$titlewords = array();
		foreach(explode(' ', $result->title) as $titleword) {
			array_push($titlewords, $titleword);
		}

		$keywords = array_diff($keywords, $titlewords);

		$keywords_string = "";
		foreach($keywords as $keyword) {
			$keywords_string .= $keyword . ' ';
		}
		$keywords_string = trim($keywords_string, ' ');

		$media =  new self($result->title, $result->description, $result->category,
			$keywords_string, $result->extension, $result->authorid);

		$media->id = $result->id;

		return $media;
	}

	public function save($file) {
		if ($this->validate() == false) {
			return -1;
		}

		$id = DB::table('media')->insertGetId(array('title' => $this->title,
										 'description' => $this->description,
										 'extension' => $this->extension,
										 'authorid' => $this->authorid,
										 'created_on' => $this->created_on,
										 'category' => $this->category));

		$keywords = array_unique(explode(' ', $this->keywords . ' ' . $this->title));
		foreach($keywords as $keyword) {
			DB::statement("INSERT INTO keywords (mediaid, keyword) VALUES (?,?)", array($id, $keyword));
		}

		$filename = $id.'.'.$this->extension;
		$uploadSuccess = $file->move(Config::get('app.file_upload_path'), $filename);

		return $id;
	}

	public function destroy(){
		DB::statement("DELETE FROM media WHERE id = ?", array($this->id));
	}

	static public function getThumbnailByID($id) {
		return Media::getByID($id)->getThumbnail();
	}

	public function getThumbnail(){
		$thumbnail = "";

		foreach (Media::$picture_formats as $format) {
			if ($this->getExtension() == strtolower($format)) {
				$thumbnail = $this->getAssetFilepath();
				return $thumbnail;
			}
		}

		foreach (Media::$audio_formats as $format) {
			if ($this->getExtension() == strtolower($format)) {
				$thumbnail = "/public/images/thumbnails/audio.png";
				return $thumbnail;
			}
		}

		foreach (Media::$qt_video_formats as $format) {
			if ($this->getExtension() == strtolower($format)) {
				$thumbnail = "/public/images/thumbnails/video.png";
				return $thumbnail;
			}
		}

		foreach (Media::$wmp_video_formats as $format) {
			if ($this->getExtension() == strtolower($format)) {
				$thumbnail = "/public/images/thumbnails/video.png";
				return $thumbnail;
			}
		}

		return $thumbnail;
	}

	public function getPlayer() {
		$player = NULL;

		foreach (Media::$picture_formats as $format) {
			if ($this->extension == strtolower($format)) {
				$player = "picture";
				return $player;
			}
		}
		
		foreach (Media::$audio_formats as $format) {
			if ($this->extension == strtolower($format)) {
				$player = "qt";
				return $player;
			}
		}
		
		foreach (Media::$qt_video_formats as $format) {
			if ($this->extension == strtolower($format)) {
				$player = "qt";
				return $player;
			}
		}

		foreach (Media::$wmp_video_formats as $format) {
			if ($this->extension == strtolower($format)) {
				$player = "wmp";
				return $player;
			}
		}

		return $player;
	}

	public function getDownloadFilename(){
		return $this->getTitle() . "." . $this->getExtension();
	}

	public function getFilename(){
		return $this->getID() . "." . $this->getExtension();
	}

	public function getAssetFilepath(){
		return "public/uploaded_media/" . $this->getFilename();
	}

	public function getFullFilename(){
		return Config::get('app.file_upload_path') . "/" . $this->getFilename();
	}

	private function validate() {
		$error_count = 0;

		if ($this->title == "")
			$this->errors[$error_count++] = "Title may not be empty";

		if ($this->getPlayer() == NULL)
			$this->errors[$error_count++] = "Filetype not supported";

		if ($error_count == 0)
			return true;
		else
			return false;
	}
}