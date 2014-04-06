@extends('media.preview-block')

@section('playlist-ordering')
  <a href = "{{route('move_playlist_item_up', array('id' => $playlist->getID(), 'order' => $item_order))}}">
    <img src = "{{ asset('public/images/arrow_up.png') }}" class = "arrow-up">
  </a>

  <a href = "{{route('move_playlist_item_down', array('id' => $playlist->getID(), 'order' => $item_order))}}">
    <img src = "{{ asset('public/images/arrow_down.png') }}" class = "arrow-down">
  </a>

  <a href = "{{route('remove_media_from_playlist', array('id' => $playlist->getID(), 'media_id' => $media->getID()))}}">
    <img src = "{{ asset('public/images/delete.png') }}" class = "delete">
  </a>
@overwrite