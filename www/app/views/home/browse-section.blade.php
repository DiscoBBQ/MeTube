<?php $i = 0; ?>
@foreach($results as $result)
  @include('home.media-preview', array('result' => $result))
  <?php $i++; ?>
@endforeach