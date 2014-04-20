@section('title')
  Upload Media
@stop

@section('error-explanation')
The following errors prevented the media from being uploaded
@stop

@section('content')
	{{ Form::open(array('route' => 'create_media', 'files' => true, 'class' => 'entry_form', 'id' => 'new_media')) }}
		<h2 class="block-title">Upload Media</h2>
		@include('partials.error-messages', array('error_messages' => $error_messages))
		<div class="form_content">
			<label for="title">Title:</label><br/>
			{{Form::text('title','', array('placeholder' => 'yet another cat video.'))}}<br>
			<label id="category-label" for="category">Category:</label>
				{{ Form::select('category', Category::getAllCategories()); }}<br/>
			<label id="file-label" for="file">File:</label>{{ Form::file('file')}}<br>
			<label for="description">Description:</label><br/>{{Form::textarea('description')}}<br/>
			<label for="keywords">Keywords:</label><br/>
			{{ Form::textarea("keywords", '', array('id' => 'keywords')) }}<br>
			<div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Upload Media</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
		</div>
	{{ Form::close() }}
@stop