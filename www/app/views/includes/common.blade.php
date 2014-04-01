@section('includes.common')
<div id = "mt-header" class>
	<div id = "mt-header-logo">
		<a href = "/"><img src = "{{asset('public/images/logo1.png')}}"></a>
	</div>
	<div id = "mt-header-content">
		{{ Form::open(array('url' => 'search')) }}
			<input id = "mt-header-content-searchbar" type = "text" name = "phrase"> 
			<input id = "mt-header-content-searchbutton" type = "submit">
				<img src = "images/search.png">
			</input>
		{{ Form::close() }}
	</div>
	<div id = "mt-header-signin">
		@if(Auth::check())
			<a class = "button" href = "/signout">
				SIGN OUT
			</a>
			&nbsp;
			<a class = "button" href = "/upload">
				UPLOAD
			</a>
		@else
			<a class = "button" href = "/signin">
				SIGN IN
			</a>
			&nbsp;
			<a class = "button" href = "/register">
				REGISTER
			</a>
		@endif
	</div>
</div>
<div id = "mt-sidebar">
	<br>
	<div class = "mt-sidebar-block">
		<div class = "mt-block-title"> BROWSE </div>
		<div class = "mt-sidebar-block-body">
			<a href = "/browse/music/1"><div class = "mt-sidebar-block-button">Music</div></a>
			<a href = "/browse/sports/1"><div class = "mt-sidebar-block-button">Sports</div></a>
			<a href = "/browse/gaming/1"><div class = "mt-sidebar-block-button">Gaming</div></a>
			<a href = "/browse/education/1"><div class = "mt-sidebar-block-button">Education</div></a>
			<a href = "/browse/movies/1"><div class = "mt-sidebar-block-button">Movies</div></a>
			<a href = "/browse/tv/1"><div class = "mt-sidebar-block-button">TV Shows</div></a>
		</div>
	</div>
	@if(Auth::check())
		<br>
		<div class = "mt-sidebar-block">
			<div class = "mt-block-title"> USER </div>
			<div class = "mt-sidebar-block-body">
				<a href = "/profile/<?php echo Auth::user()->id; ?>"><div class = "mt-sidebar-block-button">Profile</div></a>
				<a href = "/channel/<?php echo Auth::user()->id; ?>/1"><div class = "mt-sidebar-block-button">Channel</div></a>
				<a href = "/uploaded/<?php echo Auth::user()->id; ?>/1"><div class = "mt-sidebar-block-button">Uploaded</div></a>
				<a href = "/downloaded/<?php echo Auth::user()->id; ?>/1"><div class = "mt-sidebar-block-button">Downloaded</div></a>
				<a href = "/viewed/<?php echo Auth::user()->id; ?>/1"><div class = "mt-sidebar-block-button">Viewed</div></a>
				<a href = "/favorited/<?php echo Auth::user()->id; ?>/1"><div class = "mt-sidebar-block-button">Favorited</div></a>
			</div>
		</div>
		<br>
		<div class = "mt-sidebar-block">
			<div class = "mt-block-title"> PLAYLISTS </div>
			<div class = "mt-sidebar-block-body">
				<a href = "/createplaylist"><div class = "mt-sidebar-block-button">Create Playlist</div></a>
				<?php
					$result = DB::select("SELECT * FROM playlist WHERE user_id = ? ORDER BY id", array(Auth::user()->id));
					foreach($result as $playlist) {
						echo '<a href = "/playlist/'.$playlist->id.'/1"><div class = "mt-sidebar-block-button">'.$playlist->title.'</div></a>';
					}
				?>
			</div>
		</div>
	@endif
</div>
@stop