@section('content')
  @foreach($results as $result)
    <? $media = Media::getByID($result->id); ?>

    @include('media.preview-block', array('media' => $media))
  @endforeach
@stop