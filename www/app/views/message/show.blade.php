@section('title')
  Messages - {{$message->subject}}
@stop

@section('content')
  @include('message.message-with-parent', array('message' => $message))
  <a id="reply-button" class="button" href="{{route('message_reply', array('id'=>$message->getID()))}}"><span class="oi" data-glyph="share"></span> Reply</a>
@stop