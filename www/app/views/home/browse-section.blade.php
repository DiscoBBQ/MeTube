@if(count($medias) <= 0)
  No media uploaded yet!
@endif

@foreach($medias as $media)
  @include('home.media-preview', array('media' => $media))
@endforeach