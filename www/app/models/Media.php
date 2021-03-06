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
	public $file;

	public $errors = array();

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
		return self::getMediaByInteractionAndUserID(Interaction::getDownloadedString(), $user_id);
	}

	static public function getFavoritedByUserID($user_id){
		return self::getMediaByInteractionAndUserID(Interaction::getFavoritedString(), $user_id);
	}

	static public function getViewedByUserID($user_id){
		return self::getMediaByInteractionAndUserID(Interaction::getViewedString(), $user_id);
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

	static public function getMediaByKeywordSearch($phrase){
		$keywords = Keyword::makeKeywordsArrayFromPhrase($phrase);
		$results = DB::select("SELECT media.*, mediaid FROM keywords,media WHERE media.id = keywords.mediaid AND keywords.keyword IN(?) GROUP BY mediaid ORDER BY COUNT(*) desc", $keywords);
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

	public function save() {
		if ($this->validate() == false) {
			return false;
		}

		try {
			DB::beginTransaction();
			if($this->id == NULL){

				//since the video will be converted, we need to get the correct extension to use for the player
				$this->extension = FileConverter::getFinalExtensionForFile($this->file);

	      //insert the record into the DB
	      DB::statement("INSERT INTO media (title, description, extension, authorid, category) VALUES (?,?,?,?,?)", array($this->title, $this->description, $this->extension, $this->authorid, $this->category));
	      //get the ID of the last inserted record
	      $this->id = intval(DB::getPdo()->lastInsertId('id'));

	      //Convert the file and move it to its final location
	      FileConverter::ConvertFileBasedOnID($this->file, $this->id);
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
			$this->errors["file"] = "There was an error converting your file.";
			return false;
		}
	}

	public function destroy(){
		DB::statement("DELETE FROM media WHERE id = ?", array($this->id));
		Keyword::deleteAllKeywordsForMedia($this->id);
		Comment::deleteAllCommentsForMedia($this->id);
		Interaction::deleteAllInteractionsForMedia($this->id);
		Playlist::deleteAllPlaylistItemsForMedia($this->id);
	}

	static public function getThumbnailByID($id) {
		return Media::getByID($id)->getThumbnail();
	}

	public function getThumbnail(){
		$player = $this->getPlayer();
		if($player == "video"){
			return "/public/images/thumbnails/video.png";
		}

		if($player == "audio"){
			return "/public/images/thumbnails/audio.png";
		}

		if($player == "image"){
			return $this->getAssetFilepath();
		}

		return "";
	}

	public function isAudio(){
		return $this->getPlayer() == "audio";
	}

	public function isVideo(){
		return $this->getPlayer() == "video";
	}

	public function isImage(){
		return $this->getPlayer() == "image";
	}

	public function getPlayer() {
		if(FileConverter::isAudio($this->extension)){
			return "audio";
		}

		if(FileConverter::isVideo($this->extension)){
			return "video";
		}

		if(FileConverter::isImage($this->extension)){
			return "image";
		}

		return NULL;
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

	protected function sanitizeData(){
		$this->title 			 = stripslashes(trim($this->title));
    $this->description = stripslashes(trim($this->description));

		if($this->file != NULL){
			$this->extension = strtolower($this->file->getClientOriginalExtension());
		}
	}

	private function validate() {
		$this->sanitizeData();

		//only validate the file if we're creating media
		if($this->id == NULL){
			if($this->file == NULL){
				$this->errors["file"] = "File must be provided";
			} else{

				if(($this->file->getError() != UPLOAD_ERR_OK)){
					$this->errors["file"] = "Could not upload your file. Please try again.";
				}

				if(($this->file->getError() == UPLOAD_ERR_INI_SIZE) || ($this->file->getError() == UPLOAD_ERR_FORM_SIZE)){
					$filesize = Symfony\Component\HttpFoundation\File\UploadedFile::getMaxFilesize()/1048576;
					$this->errors["file"] = "Woah, that's a big file! We can only let you upload files under " . $filesize . "MB";
				}
			}
		}

		if ($this->title == ""){
			$this->errors["title"] = "Title may not be empty";
		}

		if ($this->getPlayer() == NULL){
			$this->errors["extension"] = "Filetype not supported";
		}

		if (count($this->errors) <= 0){
			return true;
		} else{
			return false;
		}
	}
}