@section('content')
	@foreach($results as $result)
    <? $media = Media::getByID($result->id); ?>

    @include('media.playlist-preview-block', array('media' => $media, 'playlist_id' => $playlist_id, 'item_order' => $result->item_order))
  @endforeach
@stop