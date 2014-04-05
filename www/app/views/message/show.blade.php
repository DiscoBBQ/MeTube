@section('content')
  <?php $sender = $message->getSender(); ?>
  <? $recipient = $message->getRecipient() ?>
  <div id="message">
    <div id="message-subject">
      <h3>{{$message->subject}}</h3>
    </div>
    <div id="message-info">
      <p>Sent: {{ $message->getCreatedAt()->format('m/d/Y H:i:s') }}</p>
      <p>From: <a href="{{route('profile', array('id' => $sender->getID())) }}">{{ $sender->username }}</a></p>
      <p>To: <a href="{{route('profile', array('id' => $recipient->getID())) }}">{{ $recipient->username }}</a></p>
    </div>
    <div id="message-message">
      <p>{{$message->message}}</p>
    </div>
  </div>
@stop