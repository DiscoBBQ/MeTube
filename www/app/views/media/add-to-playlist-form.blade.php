{{ Form::open(array('route' => array('add_media_to_playlist', $media->getID()))) }}
  <?php
    $playlists = array();

    $results = DB::select("SELECT * FROM playlist WHERE user_id = ?", array(Auth::user()->id));
    foreach($results as $playlist) {
      $playlists[$playlist->id] = $playlist->title;
    }
  ?>

  <label for="playlist">Playlist:</label> {{ Form::select('playlist', $playlists); }}<br>
  <input type = "submit" class = "mt-form-submit" value = "ADD">
{{ Form::close() }}