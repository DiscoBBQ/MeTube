<?php $comments = Comment::getAllCommentsForMedia($media->getID()) ?>

@foreach($comments as $comment)
  <div class = "mt-sidebar-block">
    <div class = "mt-block-title"><a href="{{route('profile', array('id' => $comment->getCommentor()->getID()))}}">{{$comment->getCommentor()->channel_name}}</a></div>
    <div class = "mt-sidebar-block-body">{{$comment->comment}}</div>
  </div>
@endforeach