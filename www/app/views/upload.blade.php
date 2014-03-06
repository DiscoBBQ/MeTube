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
				{{ Form::open(array('url' => 'upload_post', 'files' => true)) }}
     				Title: <input type = "text" name = "title"><br>
					Description: <input type = "text" name = "description"><br>
					File: <input type= "file" name= "file" id= "file">
					<input type = "submit" class = "mt-form-submit" value = "UPLOAD">
				{{ Form::close() }}
			</div>
		</div>
	</body>
</html>