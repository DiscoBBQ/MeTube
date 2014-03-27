<!doctype html>
<html>
	<head>
		<?php
			$media = Media::getByID($id);

			if(Auth::check()) {
				$result = DB::select("SELECT * FROM interactions WHERE user_id = ? AND media_id = ? AND category = 'viewed'", array(Auth::user()->id, $id));

				if (sizeof($result) == 0)
					DB::statement("INSERT INTO interactions (user_id, media_id, category) VALUES (?,?,'viewed')", array(Auth::user()->id, $id));
			}
		?>
		<title>MeTube - <?php echo $media->getTitle(); ?></title>
		<link href = "/css/common.css" rel = "stylesheet" type = "text/css">
	</head>

	<body>
		<div id = "mt-container">
			@yield('includes.common')
			<div id = "mt-welcome">
				<div id = "mt-welcome-media-container">

					<div class = "mt-welcome-media-block-header border-top">
						<?php
							echo $media->getTitle();
						?>
					</div>

					<div id = "mt-welcome-media-block">
						<?php
						$player = $media->getPlayer();

						if ($player == 'picture') {
							echo '<img class = "mt-media-img" src = "/uploaded_media/'.$id.'.'.$media->getExtension().'">';
						} else if ($player == 'wmp') {
							echo '<OBJECT ID="MediaPlayer" WIDTH=320 HEIGHT=240 
									CLASSID="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" 
									STANDBY="Loading Windows Media Player components..." 
									TYPE="application/x-oleobject" 
									CODEBASE="http://activex.microsoft.com/activex/controls/mplay
									er/en/nsmp2inf.cab#Version=6,4,7,1112"> 
	 								<PARAM name="autoStart" value="True"> 
	 								<PARAM name="filename" 
									value="http://WebServer/MyFile.wvx"> 
	 								<EMBED TYPE="application/x-mplayer2" 
									SRC="http://WebServer/MyFile.wvx"
									NAME="MediaPlayer" 
									WIDTH=720 HEIGHT=405> 
	 								</EMBED> 
									</OBJECT>';
						} else {
							echo '<object classid="clsid:02BF25D5-8C17-4B23-BC80-
									D3488ABDDC6B" width="320" height="256" 
									codebase="http://www.apple.com/qtactivex/qtplugin.cab#version
									=6,0,2,0" align="middle" > 
	 								<param name="src" value="sample.mov" /> 
	 								<param name="autoplay" value="true" /> 
	 								<embed
	 								src="/uploaded_media/'.$id.'.'.$media->getExtension().'"
	 								width="720" height="405" 
									pluginspage=http://www.apple.com/quicktime/download/ 
									align="middle" autoplay="true" bgcolor="black" > 
									</embed> 
									</object>';
						}
						?>
					</div>

					<div class = "mt-welcome-media-block-header">
						INFO
					</div>

					<div class = "mt-welcome-media-block-footer">

						Author: <a href = "/profile/<?php echo $media->getAuthorId(); ?>" class = "text-link"><?php
							$user = User::getByID($media->getAuthorId());
							echo $user->username;
						?></a>
						<br>
						Category: <a href = "/browse/<?php echo $media->getCategory(); ?>/1" class = "text-link"><?php
							echo $media->getCategory();
						?></a>

						<a class = "button abs-right" href = "/download/
							<?php
								echo $id;
							?>
						">
							DOWNLOAD
						</a>
						@if(Auth::check())
						<a class = "button abs-right2" href = "/favorite/
							<?php
								echo $id;
							?>
						">
							FAVORITE
						</a>
						@endif
					</div>
					<div class = "mt-welcome-media-block-header">
						DESCRIPTION
					</div>
					<div class = "mt-welcome-media-block-footer">
						<?php
							echo $media->getDescription();
						?>
					</div>

					<div class = "mt-welcome-media-block-header">
						COMMENTS
					</div>

					<div class = "mt-welcome-media-block-comments">
						
					</div>
					<div class = "mt-welcome-media-block-header-bottom">
						1 2 3 4 5 6
					</div>
				</div>
			</div>
		</div>
	</body>
</html>