<a href = "{{ route('media', array('id' => $media->getID())) }}">
  <div class = "home-img-border">
    <img class = "home-img" src="{{asset($media->getThumbnail())}}">
  </div>
  <div class = "home-title-box">
    {{ $media->title }}
  </div>
</a>