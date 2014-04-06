<?php

class BrowseController extends BaseController {
	protected $layout = 'application';

	public function browseCategory($category, $page)
	{
    $medias = Media::getMediaForCategory($category);
    $data = array('medias' => $medias);
		$this->layout->content = View::make('browse.media-list')->with($data);
	}

  public function browseDownloaded($userid, $page)
  {
    $medias = Media::getDownloadedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseFavorited($userid, $page)
  {
    $medias = Media::getFavoritedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseViewed($userid, $page)
  {
    $medias = Media::getViewedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

  public function browseUploaded($userid, $page)
  {
    $medias = Media::getUploadedByUserID($userid);
    $data = array('medias' => $medias);
    $this->layout->content = View::make('browse.media-list')->with($data);
  }

}