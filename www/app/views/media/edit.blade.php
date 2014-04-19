@section('title')
  Edit Media
@stop

@section('error-explanation')
The following errors prevented the media from being updated
@stop

@section('content')
	<div id = "mt-upload-inner">
		<div class = "block-title">Edit Media</div>
		<div class = "mt-form-box">
			@include('partials.error-messages', array('error_messages' => $error_messages))
			{{ Form::open(array('route' => array('update_media',$media->getID()))) }}
 				<label for="title">Title:</label>{{Form::text('title', $media->title)}}<br>
				<label for="description">Description:</label><br/>{{Form::textarea('description', $media->description)}}<br>
				<label for="category">Category:</label>
					{{ Form::select('category', array('Music' => 'Music',
							'Sports' => 'Sports',
							'Gaming' => 'Gaming',
							'Education' => 'Education',
							'Movies' => 'Movies',
							'TV' => 'TV Shows'), $media->category);
					}}
				<br>
				<label for="keywords">Keywords:</label>{{ Form::text("keywords", $media->keywords) }}<br>
				<input type = "submit" class = "mt-form-submit" value = "Update">
			{{ Form::close() }}
		</div>
	</div>
@stop