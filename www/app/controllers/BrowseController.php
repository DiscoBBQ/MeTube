<?php

class BrowseController extends BaseController {
	protected $layout = 'application';

	public function browseCategory($category)
	{
    $medias = Media::getMediaForCategory($category);
    $data = array('medias' => $medias);
		$this->layout->content = View::make('browse.media-list')->with($data);
	}

  public function browseDownloaded($userid)
  {
    $medias = Media::getDownloadedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseFavorited($userid)
  {
    $medias = Media::getFavoritedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseViewed($userid)
  {
    $medias = Media::getViewedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseUploaded($userid)
  {
    $medias = Media::getUploadedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

}