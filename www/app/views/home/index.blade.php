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
        <a href = "{{ route('browse_category', array('category' => $category['url'], 'page' => 1)) }}">{{$category['name']}}</a>
      </div>
      <div id = "welcome-browse-block-body">
        <?php
          $results = DB::select('select * from media where category = ? 
            order by id desc limit 4', array($category["name"]));
        ?>
        @include('home.browse-section', array('results' => $results))
      </div>
    </div><br>
  @endforeach
@stop