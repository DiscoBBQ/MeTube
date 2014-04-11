<?php $i = 0; ?>

@if(count($results) <= 0)
  No media uploaded yet!
@endif

@foreach($results as $result)
  @include('home.media-preview', array('result' => $result))
  <?php $i++; ?>
@endforeach