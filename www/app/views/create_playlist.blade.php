<!doctype html>
<html>
	<head>
		<title>MeTube - Create Playlist</title>
		<link href = "/css/common.css" rel = "stylesheet" type = "text/css">
	</head>

	<body>
		<div id = "mt-container">
			@yield('includes.common')
			<div id = "mt-welcome">

				<div id = "mt-upload-inner">
					<div class = "mt-block-title">
						New Playlist
					</div>
					<div class = "mt-form-box">
						{{ Form::open(array('url' => 'createplaylist')) }}
     					Title: <input type = "text" name = "title">
     					<br>
						Description: <input type = "text" name = "description">
						<br>
						<input type = "submit" class = "mt-form-submit" value = "CREATE">
						{{ Form::close() }}
					<div>
				</div>
			</div>
		</div>
	</body>
</html>