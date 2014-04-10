@section('title')
  Messages - Inbox
@stop

@section('content')
  <h2>Inbox</h2>
  <a href="{{route('new_message')}}">New Message</a><br>
  <a href="{{route('sent_messages')}}">Sent Messages</a>
  @include('message.message-list', array('messages' => $messages))
@stop