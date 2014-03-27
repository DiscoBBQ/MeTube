<!doctype html>
<html>
	<head>
		<title>MeTube - <?php
							$results = DB::select("SELECT title, description FROM playlist WHERE id = ?", array($id));
							echo $results[0]->title;
							echo ": ";
							echo $results[0]->description;
		 				?></title>
		<link href = "/css/common.css" rel = "stylesheet" type = "text/css">
	</head>

	<body>
		<div id = "mt-container">
			@yield('includes.common')
			<div id = "mt-welcome">
				<?php
					$results = DB::select("SELECT * FROM media,playlist_item WHERE playlist_id = ? AND id = media_id ORDER BY item_order", array($id));

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
								<img class = "browse-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
								</div>
								</a>

								<div id = "welcome-browse-block-info">
									Author: <a class = "text-link" href = "/profile/'.$result->authorid.'">'.$user->username.'</a><br>
									Category: <a class = "text-link" href = "/browse/'.$result->category.'/1">'.$result->category.'</a><br>
									Description: '.$result->description.'
								</div>
								<a href = "/playlist/up/'. $id . '/' . $result->item_order . '/' . $page . '"><img src = "/images/arrow_up.png" class = "arrow-up"></a>
								<a href = "/playlist/down/'. $id . '/' . $result->item_order . '/' . $page . '"><img src = "/images/arrow_down.png" class = "arrow-down"></a>
							</div>
						</div><br>
						';
					}

					if (sizeof($results) > 0) {
						$results = DB::select("SELECT * FROM media,playlist_item WHERE playlist_id = ? AND id = media_id", array($id));
						$size = sizeof($results);

						echo '<div class = "page-bar">';

						if ($page > 1) {
							echo '<a href = "/playlist/'.$id.'/'.($page - 1).'"><</a>';
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
							echo '<a href = "/playlist/'.$id.'/'.($i+1).'">';
							echo $i+1;
							echo '</a>';
							echo ' ';
						}

						if ($page < $size/6) {
							echo '<a href = "/playlist/'.$id.'/'.($page + 1).'">></a>';
							echo ' ';
						}

						echo '</div>';
					}
				?>
			</div>
		</div>
	</body>
</html>