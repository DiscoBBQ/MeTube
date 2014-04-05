<table>
  <thead>
    <tr>
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
      <td><a href="{{ route('profile', array('id' => $sender->getID())) }}">{{ $sender->username }}</td>
      <td><a href="{{ route('message', array('id' => $message->getID())) }}">{{ $message->subject}}</td>
      <td>{{ $message->getCreatedAt()->format('m/d/Y H:i:s') }}</td>
      <td><a href="{{ route('profile', array('id' => $recipient->getID())) }}">{{ $recipient->username }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
