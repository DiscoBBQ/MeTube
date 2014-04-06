@section('content')
  <div id="playlist">
    <div class="header">
      <div class="title">{{$playlist->title}}</div>
      <div class="description">{{$playlist->description}}</div>
      <a href="{{ route('delete_playlist', array('id' => $playlist->getID())) }}">Delete Playlist</a>
    </div>
    <div class="media">
      <?php $medias = Media::getMediaForPlaylistID($playlist->getID()); ?>
      @foreach($medias as $item_order => $media)
        @include('media.playlist-preview-block', array('media' => $media, 'playlist' => $playlist, 'item_order' => $item_order))
      @endforeach
    </div>
@stop