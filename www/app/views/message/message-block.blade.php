<?php $sender = $message->getSender(); ?>
<? $recipient = $message->getRecipient() ?>
<div class="message">
  <h2 class='block-title message-subject'>{{{$message->subject}}}</h2>
  <div class="message-info">
    <p><strong>Sent:</strong> {{ $message->getCreatedAt()->format('m/d/Y H:i:s') }}</p>
    <p><strong>From:</strong> <a class='text-link' href="{{route('profile', array('id' => $sender->getID())) }}">{{{ $sender->channel_name }}}</a></p>
    <p><strong>To:</strong> <a class='text-link' href="{{route('profile', array('id' => $recipient->getID())) }}">{{{ $recipient->channel_name }}}</a></p>
  </div>
  <div class="message-message">
    <p>{{{$message->message}}}</p>
  </div>
</div>