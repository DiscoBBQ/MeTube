<?php $comments = Comment::getAllCommentsForMedia($media->getID()) ?>

@if(count($comments) <= 0)
  <p id="no-comments">No comments. Add your own!</p>
@endif

@foreach($comments as $comment)
  <div id="comment-{{$comment->getID()}}" class = "comment">
    <div class='comment-information'>
      <a href="{{route('profile', array('id' => $comment->getCommentor()->getID()))}}" class="text-link commenter">{{{$comment->getCommentor()->channel_name}}}</a>
      <a href="#comment-{{$comment->getID()}}" class='permalink'>(link to this comment)</a>
    </div>
    <p>{{{$comment->comment}}}</p>
  </div>
@endforeach