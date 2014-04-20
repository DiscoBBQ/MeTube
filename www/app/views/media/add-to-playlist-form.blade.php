{{ Form::open(array('route' => array('add_media_to_playlist', $media->getID()))) }}
  <?php
    $playlists = Playlist::convertPlaylistsToSelectBoxArray(Playlist::getAllPlaylistsForUserID(Auth::user()->getAuthIdentifier()));
  ?>

  @if(count($playlists) > 0)

    {{ Form::select('playlist', $playlists); }}<br/><button type = "submit" class = "mt-form-submit"><span class="oi" data-glyph="plus"></span>Add to Playlist</button>
  @endif
{{ Form::close() }}