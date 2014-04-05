@section('content')
  <div class="errors">
    @if(isset($error_messages) && count($error_messages > 0))
      <p>The following errors prevented the message from being sent</p>
      <ul>
      @foreach($error_messages as $error)
        <li>{{$error}}</li>
      @endforeach
      </ul>
    @endif
  </div>
  {{Form::open(array('route' => 'create_message'))}}
    <label for="to_user_id">Recipient</label>{{ Form::select('to_user_id', $to_user_field) }}<br/>
    <label for="subject" >Subject</label><br/>
    <input type="text" name="subject" placeholder="Hello!" /><br/>
    <label for="message">Message</label><br/>
    <textarea name="message"></textarea><br/>
    {{Form::submit('Send Message');}}
  {{Form::close()}}

@stop