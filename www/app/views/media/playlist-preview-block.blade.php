@extends('media.preview-block')

@section('playlist-ordering')
  <div class="actions playlist-actions">
    <a href = "{{route('move_playlist_item_up', array('id' => $playlist->getID(), 'order' => $item_order))}}">
      <span title="Move Item Up" class="oi" data-glyph="arrow-circle-top"></span>
    </a>

    <a href = "{{route('move_playlist_item_down', array('id' => $playlist->getID(), 'order' => $item_order))}}">
      <span title="Move Item Down" class="oi" data-glyph="arrow-circle-bottom"></span>
    </a>

    <a href = "{{route('remove_media_from_playlist', array('id' => $playlist->getID(), 'media_id' => $media->getID()))}}">
      <span title="Delete Item" class="oi" data-glyph="delete"></span>
    </a>
  </div>
@overwrite