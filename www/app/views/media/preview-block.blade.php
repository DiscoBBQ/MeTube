<div class= "preview-block">
  <div class = "block-title block-title-left preview-block-title">
    <a href="{{route('media', array('id' => $media->getID()))}}">{{$media->title}}</a>
  </div>
  <div class='preview-block-body'>
    <div class="preview-thumbnail">
      <a href="{{route('media', array('id' => $media->getID()))}}">
        @include('media.thumbnail', array("media" => $media))
      </a>
      <div class="media-stats">
        <ul>
          <li>{{ Interaction::countViewedForMedia($media->getID()) }} <span class="oi views-icon" data-glyph="eye"></span></li>
          <li>{{ Interaction::countDownloadedForMedia($media->getID()) }} <span class="oi downloads-icon" data-glyph="data-transfer-download"></span></li>
          <li>{{ Interaction::countFavoritedForMedia($media->getID()) }} <span class="oi favorites-icon" data-glyph="star"></span></li>
        <ul>
      </div>
    </div>

    <div class = "preview-block-info">
      <div class="author">
        <strong>Author:</strong> <a class = "text-link" href = "{{ route('profile', array('id' => $media->getAuthor()->getID())) }}">{{$media->getAuthor()->channel_name}}</a>
      </div>
      
      <div class="category">
        <strong>Category:</strong> <a class = "text-link" href = "{{ route('browse_category', array('category' => $media->category)) }}">{{$media->category}}</a>
      </div>
      <div class="description">{{ $media->description }}</div>
      @yield('playlist-ordering','')
    </div>
  </div>
</div><br/>