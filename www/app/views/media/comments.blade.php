<?php $comments = Comment::getAllCommentsForMedia($media->getID()) ?>

@foreach($comments as $comment)
  <div id="comment-{{$comment->getID()}}" class = "mt-sidebar-block">
    <div class = "mt-block-title"><a href="#comment-{{$comment->getID()}}">#{{$comment->getID()}}</a> <a href="{{route('profile', array('id' => $comment->getCommentor()->getID()))}}">{{$comment->getCommentor()->channel_name}}</a></div>
    <div class = "mt-sidebar-block-body">{{$comment->comment}}</div>
  </div>
@endforeach