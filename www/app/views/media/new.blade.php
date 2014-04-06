@section('error-explanation')
The following errors prevented the message from being sent
@stop

@section('content')
	<div id = "mt-upload-inner">
		<div class = "mt-block-title">Upload</div>
		<div class = "mt-form-box">
			@include('partials.error-messages', array('error_messages' => $error_messages))
			{{ Form::open(array('route' => 'create_media', 'files' => true)) }}
 				<label for="title">Title:</label><input type = "text" name = "title"><br>
				<label for="description">Description:</label><input type = "text" name = "description"><br>
				<label for="category">Category:</label>
					{{ Form::select('category', array('Music' => 'Music',
							'Sports' => 'Sports',
							'Gaming' => 'Gaming',
							'Education' => 'Education',
							'Movies' => 'Movies',
							'TV' => 'TV Shows'));
					}}
				<br>
				<label for="keywords">Keywords:</label><input type = "text" name = "keywords">
				<br>
				<label for="file">File:</label><input type= "file" name = "file" id = "file">
				<br>
				<input type = "submit" class = "mt-form-submit" value = "UPLOAD">
			{{ Form::close() }}
		</div>
	</div>
@stop