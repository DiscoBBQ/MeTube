@section('title')
  Messages - Reply To Message
@stop

@section('error-explanation')
The following errors prevented the message from being sent
@stop

@section('content')
  {{Form::open(array('route' => array('reply_to_message', $parent_message->getID()), 'class' => 'entry_form', 'id' => 'new_message'))}}
    <h2 class="block-title">New Message</h2>
    @include('partials.error-messages', array('error_messages' => $error_messages))
    <div class="form_content">
      <label for="subject" >Subject</label><br/>
      {{ Form::text('subject', $first_subject, array('id' => 'subject', 'placeholder' => "Hello!") ) }}
      <label for="message">Message</label><br/>
      {{ Form::textarea("message", '', array('placeholder' => "How are you today?")) }}
      <div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Send Reply</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
    </div>
  {{Form::close()}}
@stop