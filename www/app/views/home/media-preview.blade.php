<a class="category-block-preview" href = "{{ route('media', array('id' => $media->getID())) }}">
  <div class="media-preview-container">
    <img class="media-preview" src="{{asset($media->getThumbnail())}}">
  </div>
  <div class = "media-title">
    {{ $media->title }}
  </div>
</a>