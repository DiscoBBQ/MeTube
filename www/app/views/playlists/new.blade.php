@section('title')
  New Playlist
@stop

@section('error-explanation')
The following errors prevented the playlist from being created
@stop

@section('content')
  <div id = "mt-upload-inner">
    <div class = "block-title">
      New Playlist
    </div>
    <div class = "mt-form-box">
      @include('partials.error-messages', array('error_messages' => $error_messages))
      {{ Form::open(array('route' => 'create_playlist')) }}
        <label for="title">Title: </label>{{Form::text('title')}}<br>
        <label for="description">Description: </label><br/>
        {{ Form::textarea('description') }}<br>
        <input type = "submit" class = "mt-form-submit" value = "CREATE">
      {{ Form::close() }}
    <div>
  </div>
@stop