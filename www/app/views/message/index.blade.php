@section('title')
  Messages - Inbox
@stop

@section('content')
  <h2><span class="oi" data-glyph="inbox"></span>Inbox</h2>
  <div id="actions">
    <a class="button" href="{{route('new_message')}}"><span class="oi" data-glyph="pencil"></span>New Message</a>
    <a class="button" href="{{route('sent_messages')}}"><span class="oi" data-glyph="envelope-closed"></span>Sent Messages</a>
  </div>
  @if(count($messages) <= 0)
    <p id="no-messages">No messages yet</p>
  @else
    @include('message.message-list', array('messages' => $messages))
  @endif
@stop