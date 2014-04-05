@extends('media.preview-block')

@section('playlist-ordering')
  <a href = "{{route('move_playlist_item_up', array('id' => $playlist_id, 'order' => $item_order))}}">
    <img src = "{{ asset('public/images/arrow_up.png') }}" class = "arrow-up">
  </a>

  <a href = "{{route('move_playlist_item_down', array('id' => $playlist_id, 'order' => $item_order))}}">
    <img src = "{{ asset('public/images/arrow_down.png') }}" class = "arrow-down">
  </a>
@stop