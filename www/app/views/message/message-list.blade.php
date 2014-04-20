<table id="messages">
  <thead>
    <tr>
      <th></th>
      <th>From</th>
      <th>Subject</th>
      <th>Sent</th>
      <th>To</th>
    </tr>
  </thead>
  <tbody>
  @foreach($messages as $message)
    <? $sender = $message->getSender() ?>
    <? $recipient = $message->getRecipient() ?>
    <tr>
      <td><a class="text-link" href="{{ route('message', array('id' => $message->getID())) }}"><span class="oi" data-glyph="envelope-open"></span></td>
      <td><a class="text-link" href="{{ route('profile', array('id' => $sender->getID())) }}">{{{ $sender->channel_name }}}</td>
      <td><a class="text-link" href="{{ route('message', array('id' => $message->getID())) }}">{{{ $message->subject}}}</td>
      <td>{{ $message->getCreatedAt()->format('m/d/Y H:i:s') }}</td>
      <td><a class="text-link" href="{{ route('profile', array('id' => $recipient->getID())) }}">{{{ $recipient->channel_name }}}</td>
    </tr>
  @endforeach
  </tbody>
</table>
