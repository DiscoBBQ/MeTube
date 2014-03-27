<!doctype html>
<html>
	<head>
		<title>MeTube - Profile: <?php echo User::getById($id)->username; ?></title>
		<link href = "/css/common.css" rel = "stylesheet" type = "text/css">
	</head>

	<body>
		<div id = "mt-container">
			@yield('includes.common')
			<div id = "mt-welcome">
				<div id = "profile-links">
					<a href = "/uploaded/<?php echo $id; ?>/1"><span class = "">UPLOADED</span></a> | 
					<a href = "/downloaded/<?php echo $id; ?>/1"><span class = "">DOWNLOADED</span></a> | 
					<a href = "/viewed/<?php echo $id; ?>/1"><span class = "">VIEWED</span></a> | 
					<a href = "/favorited/<?php echo $id; ?>/1"><span class = "">FAVORITED</span></a>
				</div>
				<br>
				<div class = "mt-sidebar-block">
					<div class = "mt-block-title"> <?php echo User::getById($id)->username; ?> </div>
						<div class = "mt-sidebar-block-body">
						content<br>
						content<br>
						content<br>
						content<br>
						content<br>
						content<br>
					</div>
				</div>
				<br>
				<center><a href = "/subscribe/<?php echo $id; ?>" class = "button">SUBSCRIBE</a></center>
			</div>
		</div>
	</body>
</html>