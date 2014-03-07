<!doctype html>
<html>
	<head>
		<title>MeTube - <?php echo $category; ?></title>
		<link href = "/css/common.css" rel = "stylesheet" type = "text/css">
	</head>

	<body>
		<div id = "mt-container">
			@yield('includes.common')
			<div id = "mt-welcome">
				<?php
				$results = DB::select('select * from media where category = ? order by id desc limit ?,6', array($category, ($page - 1) * 6));

				foreach ($results as $result) {
					$user = User::getByID($result->authorid);
					echo '
						<div id = "welcome-browse-block-indv">
							<div class = "mt-block-title-left">
								<a href = "/media/'.$result->id.'">
								'.$result->title.'
								</a>
							</div>
							<div id = "welcome-browse-block-body">
								<a href = "/media/'.$result->id.'">
								<div class = "browse-img-border">
								<img class = "browse-img" src="/uploaded_media/'.$result->id.'.'.'png'.'">
								</div>
								</a>

								<div id = "welcome-browse-block-info">
									Author: '.$user->username.'<br>
									Category: '.$result->category.'<br>
									Description: '.$result->description.'
								</div>

							</div>
						</div><br>
						';
				}

				if (sizeof($results) > 0) {

					$results = DB::select('select * from media where category = ?', array($category));
					$size = sizeof($results);

					echo '<div class = "page-bar">';

					if ($page > 1) {
						echo '<a href = "/browse/'.$category.'/'.($page - 1).'"><</a>';
						echo ' ';
					}

					$min = 0;
					if ($page - 5 > 0) {
						$min = $page - 5;
					}

					$max = $size/6;
					if ($page + 5 < $size/6) {
						$max = $page + 5;
					}

					for ($i = $min; $i < $max; $i++)
					{
						echo '<a href = "/browse/'.$category.'/'.($i+1).'">';
						echo $i+1;
						echo '</a>';
						echo ' ';
					}

					if ($page < $size/6) {
						echo '<a href = "/browse/'.$category.'/'.($page + 1).'">></a>';
						echo ' ';
					}

					echo '</div>';
				}
				?>
			</div>
		</div>
	</body>
</html>