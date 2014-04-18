@section('title')
	{{ $media->getTitle() }}
@stop

@section('content')

<div id = "mt-welcome-media-container">
	<div class = "mt-welcome-media-block-header border-top">{{$media->getTitle()}}</div>
	<div id = "mt-welcome-media-block">
		<? $filepath = $media->getAssetFilepath(); ?>
		<? $player = $media->getPlayer() ?>
		@if($player == 'image')
			<img class="mt-media-img" src="{{asset($media->getAssetFilepath())}}"/>
		@elseif($player == 'audio')
			<audio controls="control" preload="none" src="{{asset($filepath)}}" type="audio/mp3"></audio>
		@elseif($player == 'video')
			<video width="100%" height="100%" id="player1" controls="controls">
			    <source type="video/mp4" src="{{asset($filepath)}}" />
			    <object width="1024" height="576" type="application/x-shockwave-flash" data="{{asset('public/mejs/flashmediaelement.swf')}}">
			       <param name="movie" value="{{asset('public/mejs/flashmediaelement.swf')}}">
			       <param name="flashvars" value="controls=true&amp;file={{asset($filepath)}}">
			    </object>
			</video>
		@endif
	</div>
	<div class = "mt-welcome-media-block-header">INFO</div>
	<div class = "mt-welcome-media-block-footer">
		Author: <a class = "text-link" href = "{{ route('profile', array('id' => $media->getAuthor()->getID())) }}">{{$media->getAuthor()->channel_name}}</a><br>
    Category: <a class = "text-link" href = "{{ route('browse_category', array('category' => $media->category)) }}">{{$media->category}}</a><br>

		<a class = "button abs-right" href = "{{route('download_media', array('id' => $media->getID()))}}">DOWNLOAD</a>
		<div class='media-stats'>
			{{ Interaction::countViewedForMedia($media->getID()) }} Views<br/>
			{{ Interaction::countDownloadedForMedia($media->getID()) }} Downloads<br/>
			{{ Interaction::countFavoritedForMedia($media->getID()) }} Favorites<br/>
		</div>

		@if(Auth::check())
			<a class = "button abs-right2" href = "{{route('favorite_media', array('id' => $media->getID()))}}">FAVORITE</a>

			<div class = "abs-right3">
				@include('media.add-to-playlist-form', array('media' => $media))
			</div>

			@if(Auth::user()->getAuthIdentifier() == $media->getAuthor()->getAuthIdentifier())
				<a class="button" href="{{ route('edit_media', array('id' => $media->getID())) }}">Edit</a>
				<a class="button" href="{{ route('delete_media', array('id' => $media->getID())) }}">Delete</a>
			@endif
		@endif
	</div>
	<div class = "mt-welcome-media-block-header">DESCRIPTION</div>
	<div class = "mt-welcome-media-block-footer">{{ $media->description }}</div>

	<div class = "mt-welcome-media-block-header">
		COMMENTS
	</div>

	<div class = "mt-welcome-media-block-comments">
		@include('media.comments', array('media' => $media))
		@if(Auth::check())
			@include('media.new-comment', array('media' => $media, 'error_messages' => $error_messages))
		@endif
	</div>
</div>

@stop