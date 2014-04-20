@section('title')
  Messages - New Message
@stop

@section('error-explanation')
The following errors prevented the message from being sent
@stop

@section('content')
  {{Form::open(array('route' => 'create_message', 'class' => 'entry_form', 'id' => 'new_message'))}}
    <h2 class="block-title">New Message</h2>
    @include('partials.error-messages', array('error_messages' => $error_messages))
    <div class="form_content">
      <label id="recipient" for="to_user_id">Send To:</label>{{ Form::select('to_user_id', $to_user_field) }}<br/>
      <label for="subject" >Subject</label><br/>
      <input id="subject" type="text" name="subject" placeholder="Hello!" /><br/>
      <label for="message">Message</label><br/>
      <textarea name="message" placeholder="How are you today?"></textarea><br/>
      <div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Send Message</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
    </div>
  {{Form::close()}}
@stop