<?php

class Media {
	public $title;
	public $description;
	public $category;
	public $keywords;
	public $authorid;
	public $created_at;
	public $extension;
	public $id;

	public $errors = array();

	static private $picture_formats = array("png", "jpeg", "jpg", "gif", "bmp");
	static private $audio_formats = array("m4a", "m4b", "m4p", "mp3", "aiff", "au", "wav");
	static private $qt_video_formats = array("mov", "mp4", "m4v", "avi");
	static private $wmp_video_formats = array("wmv", "wma", "wm");

	public function getID() { return $this->id; }
	public function getTitle() { return $this->title; }
	public function getDescription() { return $this->description; }
	public function getCategory() { return $this->category; }
	public function getKeywords() { return $this->keywords; }
	public function getAuthorId() { return $this->authorid; }
	public function getCreatedAt() { return $this->created_at; }
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
		$results = DB::select('SELECT * FROM media WHERE authorid = ? ORDER BY created_at desc', array($user_id));

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
		$results = DB::select("SELECT media.* FROM interactions,media WHERE interactions.category = ? AND interactions.user_id = ? AND media_id = id ORDER BY created_at desc", array($interaction, $user_id));

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

		$media = new self();

		$media->id 					= intval($result->id);
		$media->title 			= $result->title;
		$media->description = $result->description;
		$media->category 		= $result->category;
		$media->keywords 		= Keyword::getKeywordStringForMediaAndItsTitle($media->id, $media->title);
		$media->extension 	= strtolower($result->extension);
		$media->authorid 		= intval($result->authorid);
		$media->created_at 	= new DateTime($result->created_at);

		return $media;
	}

	public function save($file) {
		if ($this->validate() == false) {
			return false;
		}

		try {
			if($this->id == NULL){
	      //insert the record into the DB
	      DB::statement("INSERT INTO media (title, description, extension, authorid, category) VALUES (?,?,?,?,?)", array($this->title, $this->description, $this->extension, $this->authorid, $this->category));
	      //get the ID of the last inserted record
	      $this->id = intval(DB::getPdo()->lastInsertId('id'));

	      //move the file to its final destination
	      $filename = $this->id.'.'.$this->extension;
	      $uploadSuccess = $file->move(Config::get('app.file_upload_path'), $filename);
	    } else{
	      //update the existing record in the DB
	      DB::statement("UPDATE media SET title = ?, description = ?, extension = ?, authorid = ?, category = ? WHERE id = ?", array($this->title, $this->description, $this->extension, $this->authorid, $this->category, $this->id));
	    }

	    Keyword::deleteAllKeywordsForMedia($this->id);
	    Keyword::createKeywordsForMediaFromPhrase($this->id, $this->keywords . ' ' . $this->title);
	    DB::commit();
	    return true;
		} catch (Exception $e) {
			DB::rollback();
		}
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