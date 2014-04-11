@section('title')
  Home
@stop

@section('content')
  <?php $categories = array(
      array('url' => 'music', 'name' => 'Music'),
      array('url' => 'sports', 'name' => 'Sports'),
      array('url' => 'gaming', 'name' => 'Gaming'),
      array('url' => 'education', 'name' => 'Education'),
      array('url' => 'movies', 'name' => 'Movies'),
      array('url' => 'tv', 'name' => 'TV Shows'),
      );
  ?>

  @foreach($categories as $category)
    <div id = "welcome-browse-block-indv">
      <div class = "mt-block-title-left">
        <a href = "{{ route('browse_category', array('category' => $category['url'])) }}">{{$category['name']}}</a>
      </div>
      <div id = "welcome-browse-block-body">
        <?php $recent_media = Media::getMediaForCategory($category['url']); ?>
        <?php $recent_media = array_slice($recent_media, 0, 4); ?>
        @include('home.browse-section', array('medias' => $recent_media))
      </div>
    </div><br>
  @endforeach
@stop