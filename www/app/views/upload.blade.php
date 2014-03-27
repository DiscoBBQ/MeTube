<!doctype html>
<html>
	<head>
		<title>MeTube - Upload</title>
		<link href = "/css/common.css" rel = "stylesheet" type = "text/css">
	</head>

	<body>
		<div id = "mt-container">
			@yield('includes.common')
			<div id = "mt-welcome">


				<div id = "mt-upload-inner">
					<div class = "mt-block-title">
						Upload
					</div>
					<div class = "mt-form-box">
						{{ Form::open(array('url' => 'upload', 'files' => true)) }}
     					Title: <input type = "text" name = "title">
     					<br>
						Description: <input type = "text" name = "description">
						<br>
						Category: {{ Form::select('category', array('Music' => 'Music',
																'Sports' => 'Sports',
																'Gaming' => 'Gaming',
																'Education' => 'Education',
																'Movies' => 'Movies',
																'TV Shows' => 'TV Shows',
																'News' => 'News')); }}
						<br>
						Keywords: <input type = "text" name = "keywords">
						<br>
						File: <input type= "file" name = "file" id = "file">
						<br>
						<input type = "submit" class = "mt-form-submit" value = "UPLOAD">
						{{ Form::close() }}
					<div>
				</div>
			</div>
		</div>
	</body>
</html>