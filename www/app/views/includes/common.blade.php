@section('includes.common')
<div id = "mt-header" class>
	<div id = "mt-header-logo">
		<a href = "/"><img src = "/images/logo1.png"></a>
	</div>
	<div id = "mt-header-content">
		<form>
			<input id = "mt-header-content-searchbar" type = "text"> 
			<input id = "mt-header-content-searchbutton" type = "submit">
				<img src = "images/search.png">
			</input>
		</form>
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
			<a href = "/browse/news/1"><div class = "mt-sidebar-block-button">News</div></a>
		</div>
	</div>
	@if(Auth::check())
		<br>
		<div class = "mt-sidebar-block">
			<div class = "mt-block-title"> USER </div>
			<div class = "mt-sidebar-block-body">
				<div class = "mt-sidebar-block-button">Uploaded</div>
				<div class = "mt-sidebar-block-button">Downloaded</div>
				<div class = "mt-sidebar-block-button">Viewed</div>
				<div class = "mt-sidebar-block-button">Favorited</div>
			</div>
		</div>
		<br>
		<div class = "mt-sidebar-block">
			<div class = "mt-block-title"> PLAYLISTS </div>
			<div class = "mt-sidebar-block-body">
				<div class = "mt-sidebar-block-button">To do</div>
				<div class = "mt-sidebar-block-button">To do</div>
				<div class = "mt-sidebar-block-button">To do</div>
			</div>
		</div>
	@endif
</div>
@stop