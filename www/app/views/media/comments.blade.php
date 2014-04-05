<?php
  $results = DB::select("SELECT comment,user_id FROM comments WHERE media_id = ? ORDER BY timestamp DESC", array($media->getID()));
?>

@foreach($results as $result)
  <div class = "mt-sidebar-block">
    <div class = "mt-block-title">{{User::getById($result->user_id)->username}}</div>
    <div class = "mt-sidebar-block-body">{{$result->comment}}</div>
  </div>
@endforeach