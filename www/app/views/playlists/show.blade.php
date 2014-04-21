@section('title')
  Playlist - {{{$playlist->title}}}
@stop

@section('content')
  <div id="playlist">
    <div class="header">
      <div class="actions">
        <a class="button" href="{{ route('edit_playlist', array('id' => $playlist->getID())) }}"><span class="oi" data-glyph="pencil"></span>Edit Playlist</a>
        <a class="button" href="{{ route('delete_playlist', array('id' => $playlist->getID())) }}"><span class="oi" data-glyph="delete"></span>Delete Playlist</a>
      </div>

      <h2>{{{$playlist->title}}}</h2>
      <p class="description">{{{$playlist->description}}}</p>
    </div>
    <h3>Playlist Items</h3>
    <div class="media">
      <?php $medias = Media::getMediaForPlaylistID($playlist->getID()); ?>
      @if(count($medias) <= 0)
        <p id="no-playlist-items">No items in the playlist yet!</p>
      @endif

      @foreach($medias as $item_order => $media)
        @include('media.playlist-preview-block', array('media' => $media, 'playlist' => $playlist, 'item_order' => $item_order))
      @endforeach
    </div>
@stop