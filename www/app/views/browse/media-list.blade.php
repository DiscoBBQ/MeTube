@section('content')
  @foreach($results as $result)
    <?php $author = User::getByID($result->authorid); ?>
    <div id = "welcome-browse-block-indv">
      <div class = "mt-block-title-left">
        <a href="{{route('media', array('id' => $result -> id))}}">{{$result->title}}</a>
      </div>
      <div id='welcome-browse-block-body'>
        <a href="{{route('media', array('id' => $result -> id))}}">{{$result->title}}
          <div class = "browse-img-border">
            <img class = "browse-img" src="{{Media::getThumbnail($result->id, $result->extension)}}">
          </div>
        </a>

        <div id = "welcome-browse-block-info">
          Author: <a class = "text-link" href = "{{ route('profile', array('id' => $author->getID())) }}">{{$author->username}}</a><br>
          Category: <a class = "text-link" href = "{{ route('browse_category', array('category' => $result->category, 'page' => 1)) }}">{{$result->category}}</a><br>
          Description: {{ $result->description }}
        </div>
      </div>
    </div><br/>
  @endforeach

  @include('partials.pagination', array('params' => $pagination_params, 'current_page' => $current_page, 'count' => $count, 'route_name' => $route_name))
@stop