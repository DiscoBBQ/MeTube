@section('content')
  @foreach($medias as $media)
    @include('media.preview-block', array('media' => $media))
  @endforeach
@stop