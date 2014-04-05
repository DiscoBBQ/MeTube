@section('error-explanation')
The following errors prevented the message from being sent
@stop

@section('content')
  @include('partials.error-messages', array('error_messages' => $error_messages))
  {{Form::open(array('route' => 'create_message'))}}
    <label for="to_user_id">Recipient</label>{{ Form::select('to_user_id', $to_user_field) }}<br/>
    <label for="subject" >Subject</label><br/>
    <input type="text" name="subject" placeholder="Hello!" /><br/>
    <label for="message">Message</label><br/>
    <textarea name="message"></textarea><br/>
    {{Form::submit('Send Message');}}
  {{Form::close()}}
@stop