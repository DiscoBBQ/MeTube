@section('title')
  Edit Media
@stop

@section('error-explanation')
The following errors prevented the media from being updated
@stop

@section('content')
	{{ Form::open(array('route' => array('update_media',$media->getID()), 'class' => 'entry_form', 'id' => 'edit_media')) }}
		<h2 class="block-title">Edit Media</h2>
		@include('partials.error-messages', array('error_messages' => $error_messages))
		<div class="form_content">
			<label for="title">Title:</label><br/>
			{{Form::text('title', $media->title)}}<br>
			<label id='category-label' for="category">Category:</label>
			{{ Form::select('category', Category::getAllCategories(), $media->category);
			}}<br>
			<label for="description">Description:</label><br/>
			{{Form::textarea('description', $media->description)}}<br>
			<label for="keywords">Keywords:</label><br>
			{{ Form::textarea("keywords", $media->keywords, array('id' => 'keywords')) }}<br>
			<div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Update Media</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
    </div>
	{{ Form::close() }}
@stop