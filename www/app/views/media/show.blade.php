@section('content')

<div id = "mt-welcome-media-container">
	<div class = "mt-welcome-media-block-header border-top">{{$media->getTitle()}}</div>
	<div id = "mt-welcome-media-block">
		@if($media->getPlayer() == 'picture')
			<img class="mt-media-img" src="{{asset($media->getAssetFilepath())}}"/>
		@elseif($media->getPlayer() == 'wmp')
			<OBJECT ID="MediaPlayer" WIDTH=320 HEIGHT=240 
					CLASSID="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" 
					STANDBY="Loading Windows Media Player components..." 
					TYPE="application/x-oleobject" 
					CODEBASE="http://activex.microsoft.com/activex/controls/mplay
					er/en/nsmp2inf.cab#Version=6,4,7,1112"> 
						<PARAM name="autoStart" value="True"> 
						<PARAM name="filename" 
					value="{{asset($media->getAssetFilepath())}}"> 
						<EMBED TYPE="application/x-mplayer2" 
					SRC="{{asset($media->getAssetFilepath())}}"
					NAME="MediaPlayer" 
					WIDTH=720 HEIGHT=405> 
						</EMBED> 
			</OBJECT>
		@else
			<object classid="clsid:02BF25D5-8C17-4B23-BC80-
					D3488ABDDC6B" width="320" height="256" 
					codebase="http://www.apple.com/qtactivex/qtplugin.cab#version
					=6,0,2,0" align="middle" > 
						<param name="src" value="sample.mov" /> 
						<param name="autoplay" value="true" /> 
						<embed
						src="{{asset($media->getAssetFilepath())}}"
						width="720" height="405" 
					pluginspage=http://www.apple.com/quicktime/download/ 
					align="middle" autoplay="true" bgcolor="black" > 
					</embed> 
			</object>
		@endif
	</div>
	<div class = "mt-welcome-media-block-header">INFO</div>
	<div class = "mt-welcome-media-block-footer">
		Author: <a class = "text-link" href = "{{ route('profile', array('id' => $media->getAuthor()->getID())) }}">{{$media->getAuthor()->channel_name}}</a><br>
    Category: <a class = "text-link" href = "{{ route('browse_category', array('category' => $media->category, 'page' => 1)) }}">{{$media->category}}</a><br>

		<a class = "button abs-right" href = "{{route('download_media', array('id' => $media->getID()))}}">DOWNLOAD</a>

		@if(Auth::check())
			<a class = "button abs-right2" href = "{{route('favorite_media', array('id' => $media->getID()))}}">FAVORITE</a>

			<div class = "abs-right3">
				@include('media.add-to-playlist-form', array('media' => $media))
			</div>
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
			@include('media.new-comment', array('media' => $media))
		@endif
	</div>
</div>

@stop