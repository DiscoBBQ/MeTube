@section('title')
  Messages - Sent
@stop

@section('content')
  <h2>Sent</h2>
  <a href="{{route('new_message')}}">New Message</a><br>
  <a href="{{route('messages')}}">Inbox</a>
  @if(count($messages) <= 0)
    <p id="no-messages">No sent messages</p>
  @else
    @include('message.message-list', array('messages' => $messages))
  @endif
@stop