@section('title')
  Edit Playlist
@stop

@section('error-explanation')
The following errors prevented the playlist from being updated
@stop

@section('content')
  {{ Form::open(array('route' => array('update_playlist', $playlist->getID()), 'class' => 'entry_form', 'id' => 'edit_playlist')) }}
    <h2 class="block-title">Edit Playlist</h2>
    @include('partials.error-messages', array('error_messages' => $error_messages))
    <div class="form_content">
      <label for="title">Title:</label><br>{{ Form::text('title', $playlist->title) }}<br>
      <label for="description">Description:</label><br/>
      {{ Form::textarea('description', $playlist->description) }}<br>
      <div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Update Playlist</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
    </div>
  {{ Form::close() }}
@stop