@section('content')
  @foreach($results as $result)
    <? $media = Media::getByID($result->id); ?>

    @include('media.preview-block', array('media' => $media))
  @endforeach

  @include('partials.pagination', array('params' => $pagination_params, 'current_page' => $current_page, 'count' => $count, 'route_name' => $route_name))
@stop