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
		<a class = "button" href = "/signin">
			SIGN IN
		</a>
		&nbsp;
		<a class = "button" href = "/register">
			REGISTER
		</a>
	</div>
</div>
<div id = "mt-sidebar">
	<br>
	<div class = "mt-sidebar-block">
		<div class = "mt-block-title"> BROWSE </div>
		<div class = "mt-sidebar-block-body">
			<div class = "mt-sidebar-block-button">Music</div>
			<div class = "mt-sidebar-block-button">Sports</div>
			<div class = "mt-sidebar-block-button">Gaming</div>
			<div class = "mt-sidebar-block-button">Education</div>
			<div class = "mt-sidebar-block-button">Movies</div>
			<div class = "mt-sidebar-block-button">TV Shows</div>
			<div class = "mt-sidebar-block-button">News</div>
		</div>
	</div>
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
</div>
@stop