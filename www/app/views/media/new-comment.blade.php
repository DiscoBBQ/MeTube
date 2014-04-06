@section('error-explanation')
The following errors prevented the comment from being created
@stop

@include('partials.error-messages', array('error_messages' => $error_messages))
{{ Form::open(array('route' => array('add_comment_to_media', $media->getID()))) }}
  <center>
    {{ Form::textarea('comment', Input::old("comment")) }}
  </center>
  <input type = "submit" class = "mt-form-submit" value = "COMMENT">
{{ Form::close() }}