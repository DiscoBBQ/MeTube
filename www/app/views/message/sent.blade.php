@section('title')
  Messages - Sent Messages
@stop

@section('content')
  <h2><span class="oi" data-glyph="envelope-closed"></span>Sent Messages</h2>
  <div id="actions">
    <a class="button" href="{{route('new_message')}}"><span class="oi" data-glyph="pencil"></span>New Message</a>
    <a class="button" href="{{route('messages')}}"><span class="oi" data-glyph="inbox"></span>Inbox</a>
  </div>
  @if(count($messages) <= 0)
    <p id="no-messages">No sent messages</p>
  @else
    @include('message.message-list', array('messages' => $messages))
  @endif
@stop