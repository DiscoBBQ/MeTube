@if(count($medias) <= 0)
  <div class="category-browse-no-media"><p>No media uploaded yet!</p></div>
@endif

@foreach($medias as $media)
  @include('home.media-preview', array('media' => $media))
@endforeach