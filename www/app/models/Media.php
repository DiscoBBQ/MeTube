<?php

class Media {
	private $title;
	private $description;
	private $category;
	private $keywords;
	private $authorid;
	private $created_on;
	private $extension;

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
		$this->extension = $extension;
		$this->authorid = $authorid;

		$this->created_on = date("Y-m-d");
	}

	public function getTitle() { return $this->title; }
	public function getDescription() { return $this->description; }
	public function getCategory() { return $this->category; }
	public function getKeywords() { return $this->keywords; }
	public function getAuthorId() { return $this->authorid; }
	public function getCreatedOn() { return $this->created_on; }
	public function getExtension() { return $this->extension; }

	static public function getByID($id){
		$result = DB::select("SELECT * FROM media WHERE id = ? LIMIT 1", array($id));
		return self::buildUserFromResult($result);
	}

	static protected function buildUserFromResult($result){
		if (count($result) == 0) {
			return NULL;
		}

		return new self($result[0]->title, $result[0]->description, $result[0]->category,
			$result[0]->keywords, $result[0]->extension, $result[0]->authorid);
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
										 'category' => $this->category,
										 'keywords' => $this->keywords));

		$destinationPath = 'uploaded_media/';

		$filename = $id.'.'.$this->extension;
		$uploadSuccess = $file->move($destinationPath, $filename);

		return $id;
	}

	static public function getThumbnail($id, $extension) {
		$thumbnail = "";

		foreach (Media::$picture_formats as $format) {
			if ($extension == $format) {
				$thumbnail = '/uploaded_media/'.$id.'.'.$extension;
				return $thumbnail;
			}
		}

		foreach (Media::$audio_formats as $format) {
			if ($extension == $format) {
				$thumbnail = "/thumbnails/audio.png";
				return $thumbnail;
			}
		}

		foreach (Media::$qt_video_formats as $format) {
			if ($extension == $format) {
				$thumbnail = "/thumbnails/video.png";
				return $thumbnail;
			}
		}

		foreach (Media::$wmp_video_formats as $format) {
			if ($extension == $format) {
				$thumbnail = "/thumbnails/video.png";
				return $thumbnail;
			}
		}

		return $thumbnail;
	}

	public function getPlayer() {
		$player = NULL;

		foreach (Media::$picture_formats as $format) {
			if ($this->extension == $format) {
				$player = "picture";
				return $player;
			}
		}
		
		foreach (Media::$audio_formats as $format) {
			if ($this->extension == $format) {
				$player = "qt";
				return $player;
			}
		}
		
		foreach (Media::$qt_video_formats as $format) {
			if ($this->extension == $format) {
				$player = "qt";
				return $player;
			}
		}

		foreach (Media::$wmp_video_formats as $format) {
			if ($this->extension == $format) {
				$player = "wmp";
				return $player;
			}
		}

		return $player;
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