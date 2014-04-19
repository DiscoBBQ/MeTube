@section('title')
  Home
@stop

@section('content')
  @foreach (Category::getAllCategories() as $url => $name)
    <div class = "category-block">
      <div class = "block-title category-block-title">
        <a href = "{{ route('browse_category', array('category' => $url)) }}">{{$name}}</a>
      </div>
      <div class = "category-block-body">
        <?php $recent_media = Media::getMediaForCategory($url); ?>
        <?php $total_count  = count($recent_media); ?>
        <?php $recent_media = array_slice($recent_media, 0, 4); ?>
        @include('home.browse-section', array('medias' => $recent_media))
        @if($total_count > count($recent_media))
          <a class="category-block-preview" href = "{{ route('browse_category', array('category' => $url)) }}">
            <div class="media-preview-container">
              <span class="oi media-preview view-more" data-glyph="chevron-right"></span>
            </div>
            <div class = "media-title">
              View More
            </div>
          </a>
        @endif
      </div>
    </div>
  @endforeach
@stop