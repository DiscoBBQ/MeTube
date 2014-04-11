@section('title')
  Messages - Inbox
@stop

@section('content')
  <h2>Inbox</h2>
  <a href="{{route('new_message')}}">New Message</a><br>
  <a href="{{route('sent_messages')}}">Sent Messages</a>
  @if(count($messages) <= 0)
    <p id="no-messages">No messages yet</p>
  @else
    @include('message.message-list', array('messages' => $messages))
  @endif
@stop