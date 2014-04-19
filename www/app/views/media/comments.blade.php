<?php $comments = Comment::getAllCommentsForMedia($media->getID()) ?>

@if(count($comments) <= 0)
  <p id="no-comments">No comments. Add your own!</p>
@endif

@foreach($comments as $comment)
  <div id="comment-{{$comment->getID()}}" class = "sidebar-block">
    <div class = "block-title"><a href="#comment-{{$comment->getID()}}">#{{$comment->getID()}}</a> <a href="{{route('profile', array('id' => $comment->getCommentor()->getID()))}}">{{$comment->getCommentor()->channel_name}}</a></div>
    <div class = "sidebar-block-body">{{$comment->comment}}</div>
  </div>
@endforeach