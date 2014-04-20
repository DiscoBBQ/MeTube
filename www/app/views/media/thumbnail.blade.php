<div class="media-preview-container">
  @if($media->isVideo())
    <span class="oi media-preview video" data-glyph="video" title="video" aria-hidden="true"></span>
  @elseif($media->isAudio())
    <span class="oi media-preview audio" data-glyph="audio-spectrum"></span>
  @else
    <img class="media-preview" src="{{{asset($media->getThumbnail())}}}">
  @endif
</div>