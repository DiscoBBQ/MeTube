@section('title')
  Edit Playlist
@stop

@section('error-explanation')
The following errors prevented the playlist from being updated
@stop

@section('content')
  <div id = "mt-upload-inner">
    <div class = "block-title">
      Edit Playlist
    </div>
    <div class = "mt-form-box">
      @include('partials.error-messages', array('error_messages' => $error_messages))
      {{ Form::open(array('route' => array('update_playlist', $playlist->getID()))) }}
        <label for="title">Title: </label> {{ Form::text('title', $playlist->title) }}<br>
        <label for="description">Description: </label><br/>
        {{ Form::textarea('description', $playlist->description) }}<br>
        <input type = "submit" class = "form-button" value = "Update">
      {{ Form::close() }}
    <div>
  </div>
@stop