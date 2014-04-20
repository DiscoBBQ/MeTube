<a class="category-block-preview" href = "{{ route('media', array('id' => $media->getID())) }}">
  @include('media.thumbnail', array("media" => $media))
  <div class = "media-title">
    {{{ $media->title }}}
  </div>
</a>