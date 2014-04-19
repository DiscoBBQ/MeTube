@section('title')
  Upload Media
@stop

@section('error-explanation')
The following errors prevented the media from being uploaded
@stop

@section('content')
	<div id = "mt-upload-inner">
		<div class = "block-title">Upload</div>
		<div class = "mt-form-box">
			@include('partials.error-messages', array('error_messages' => $error_messages))
			{{ Form::open(array('route' => 'create_media', 'files' => true)) }}
 				<label for="title">Title:</label>{{Form::text('title')}}<br>
				<label for="description">Description:</label>{{Form::text('description')}}<br>
				<label for="category">Category:</label>
					{{ Form::select('category', array('Music' => 'Music',
							'Sports' => 'Sports',
							'Gaming' => 'Gaming',
							'Education' => 'Education',
							'Movies' => 'Movies',
							'TV' => 'TV Shows'));
					}}
				<br>
				<label for="keywords">Keywords:</label>{{ Form::text("keywords") }}<br>
				<label for="file">File:</label>{{ Form::file('file')}}<br>
				<input type = "submit" class = "mt-form-submit" value = "UPLOAD">
			{{ Form::close() }}
		</div>
	</div>
@stop