@section('content')
  <div id = "mt-upload-inner">
    <div class = "mt-block-title">
      New Playlist
    </div>
    <div class = "mt-form-box">
      {{ Form::open(array('route' => 'create_playlist')) }}
        <label for="title">Title: </label><input type = "text" name = "title"><br>
        <label for="description">Description: </label><input type = "text" name = "description"><br>
        <input type = "submit" class = "mt-form-submit" value = "CREATE">
      {{ Form::close() }}
    <div>
  </div>
@stop