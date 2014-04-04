<a href = "{{ route('media', array('id' => $result->id)) }}">
  <div class = "home-img-border" style="left:'{{ (($i * 175) + 15) }}'px;">
    <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
  </div>
  <div class = "home-title-box" style="left:'{{ (($i * 175) + 15) }}'px;">
    {{ $result->title }}
  </div>
</a>