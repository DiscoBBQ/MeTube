@section('error-explanation')
The following errors prevented the comment from being created
@stop

@include('partials.error-messages', array('error_messages' => $error_messages))
{{ Form::open(array('route' => array('add_comment_to_media', $media->getID()), 'id' => 'new-comment')) }}
    {{ Form::textarea('comment', Input::old("comment")) }}
    <button type = "submit" class = "form-button"><span class="oi" data-glyph="comment-square"></span>Add Comment</button>
{{ Form::close() }}