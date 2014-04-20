@section('title')
	{{ $media->getTitle() }}
@stop

@section('content')

<div id = "media">
	<div id = "media-title" class="block-title">{{{$media->getTitle()}}}</div>
	<div id="player">
		<? $filepath = $media->getAssetFilepath(); ?>
		<? $player = $media->getPlayer() ?>
		@if($media->isImage())
			<img class="media-image" src="{{{asset($media->getAssetFilepath())}}}"/>
		@elseif($media->isAudio())
			<div id="audio-player">
				<div id="audio-image">
					<span class="oi media-preview audio" data-glyph="audio-spectrum"></span>
				</div>
				<audio controls="control" preload="metadata" src="{{{asset($filepath)}}}" type="audio/mp3"></audio>
			</div>
		@elseif($media->isVideo())
			<video height="400" id="player1" controls="controls">
			    <source type="video/mp4" src="{{{asset($filepath)}}}" />
			    <object width="100" height="100" type="application/x-shockwave-flash" data="{{{asset('public/mejs/flashmediaelement.swf')}}}">
			       <param name="movie" value="{{{asset('public/mejs/flashmediaelement.swf')}}}">
			       <param name="flashvars" value="controls=true&amp;file={{{asset($filepath)}}}">
			    </object>
			</video>
		@endif
	</div>
	<div id="media-information">
		<div class="block-title">Details</div>
		<div id="information">
			<div class="actions">
				<a class = "button download" href = "{{route('download_media', array('id' => $media->getID()))}}"><span class="oi downloads-icon" data-glyph="data-transfer-download"></span>Download</a>
				@if(Auth::check())
					<a class = "button favorite" href = "{{route('favorite_media', array('id' => $media->getID()))}}"><span class="oi favorites-icon" data-glyph="star"></span>Favorite</a>

					@include('media.add-to-playlist-form', array('media' => $media))

					@if(Auth::user()->getAuthIdentifier() == $media->getAuthor()->getAuthIdentifier())
						<a class="button" href="{{ route('edit_media', array('id' => $media->getID())) }}"><span class="oi" data-glyph="pencil"></span>Edit Media</a>
						<a class="button" href="{{ route('delete_media', array('id' => $media->getID())) }}"><span class="oi" data-glyph="delete"></span>Delete Media</a>
					@endif
				@endif
			</div>

			<div class="author">
	        <strong>Author:</strong> <a class = "text-link" href = "{{ route('profile', array('id' => $media->getAuthor()->getID())) }}">{{{$media->getAuthor()->channel_name}}}</a>
	      </div>

	      <div class="category">
	        <strong>Category:</strong> <a class = "text-link" href = "{{ route('browse_category', array('category' => $media->category)) }}">{{$media->category}}</a>
	      </div>

	      <div class="media-stats">
	        <ul>
	          <li>{{ Interaction::countViewedForMedia($media->getID()) }} <span class="oi views-icon" data-glyph="eye" title="Viewed"></span></li>
	          <li>{{ Interaction::countDownloadedForMedia($media->getID()) }} <span class="oi downloads-icon" data-glyph="data-transfer-download" title="Downloaded"></span></li>
	          <li>{{ Interaction::countFavoritedForMedia($media->getID()) }} <span class="oi favorites-icon" data-glyph="star" title="Favorited"></span></li>
	        <ul>
	      </div>

	      <div class="description">{{{ $media->description }}}</div>
	      <div class="keywords">{{{ $media->keywords }}}</div>
		</div>
	</div>

	<div id="comments-section">
		<div class="block-title">Comments</div>

		<div id="comments">
			@include('media.comments', array('media' => $media))
			@if(Auth::check())
				@include('media.new-comment', array('media' => $media, 'error_messages' => $error_messages))
			@endif
		</div>
	</div>
</div>

@stop