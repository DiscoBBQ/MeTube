@section('title')
  Search
@stop

@section('content')
  @if(count($medias <= 0))
    <p class="no-media">Nothing Found!</p>
  @endif

  @foreach($medias as $media)
    @include('media.preview-block', array('media' => $media))
  @endforeach
@stop