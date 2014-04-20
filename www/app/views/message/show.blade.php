@section('title')
  Messages - {{$message->subject}}
@stop

@section('content')
  <?php $sender = $message->getSender(); ?>
  <? $recipient = $message->getRecipient() ?>
  <div id="message">
    <h2 id="message-subject" class='block-title'>{{$message->subject}}</h2>
    <div id="message-info">
      <p><strong>Sent:</strong> {{ $message->getCreatedAt()->format('m/d/Y H:i:s') }}</p>
      <p><strong>From:</strong> <a class='text-link' href="{{route('profile', array('id' => $sender->getID())) }}">{{ $sender->channel_name }}</a></p>
      <p><strong>To:</strong> <a class='text-link' href="{{route('profile', array('id' => $recipient->getID())) }}">{{ $recipient->channel_name }}</a></p>
    </div>
    <div id="message-message">
      <p>{{$message->message}}</p>
    </div>
  </div>
@stop