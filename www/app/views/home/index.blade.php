@section('content')
  <div id = "welcome-browse-block-indv">
    <div class = "mt-block-title-left">
      <a href = "/browse/music/1">Music</a>
    </div>
    <div id = "welcome-browse-block-body">
      <?php
        $results = DB::select('select * from media where category = ? 
          order by id desc limit 4', array('Music'));
        
        $i = 0;
        foreach($results as $result) {
          echo '
            <a href = "/media/'.$result->id.'">
            <div class = "home-img-border" style="left:'.(($i * 175) + 15).'px;">
              <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
            </div>
            <div class = "home-title-box" style="left:'.(($i * 175) + 15).'px;">
              '.$result->title.'
            </div>
            </a>
            ';
          $i++;
        }
      ?>
    </div>
  </div><br>

  <div id = "welcome-browse-block-indv">
    <div class = "mt-block-title-left">
      <a href = "/browse/sports/1">Sports</a>
    </div>
    <div id = "welcome-browse-block-body">
      <?php
        $results = DB::select('select * from media where category = ? 
          order by id desc limit 4', array('Sports'));
        
        $i = 0;
        foreach($results as $result) {
          echo '
            <a href = "/media/'.$result->id.'">
            <div class = "home-img-border" style="left:'.(($i * 175) + 15).'px;">
              <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
            </div>
            <div class = "home-title-box" style="left:'.(($i * 175) + 15).'px;">
              '.$result->title.'
            </div>
            </a>
            ';
          $i++;
        }
      ?>
    </div>
  </div><br>

  <div id = "welcome-browse-block-indv">
    <div class = "mt-block-title-left">
      <a href = "/browse/gaming/1">Gaming</a>
    </div>
    <div id = "welcome-browse-block-body">
      <?php
        $results = DB::select('select * from media where category = ? 
          order by id desc limit 4', array('Gaming'));
        
        $i = 0;
        foreach($results as $result) {
          echo '
            <a href = "/media/'.$result->id.'">
            <div class = "home-img-border" style="left:'.(($i * 175) + 15).'px;">
              <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
            </div>
            <div class = "home-title-box" style="left:'.(($i * 175) + 15).'px;">
              '.$result->title.'
            </div>
            </a>
            ';
          $i++;
        }
      ?>
    </div>
  </div><br>

  <div id = "welcome-browse-block-indv">
    <div class = "mt-block-title-left">
      <a href = "/browse/education/1">Education</a>
    </div>
    <div id = "welcome-browse-block-body">
      <?php
        $results = DB::select('select * from media where category = ? 
          order by id desc limit 4', array('Education'));
        
        $i = 0;
        foreach($results as $result) {
          echo '
            <a href = "/media/'.$result->id.'">
            <div class = "home-img-border" style="left:'.(($i * 175) + 15).'px;">
              <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
            </div>
            <div class = "home-title-box" style="left:'.(($i * 175) + 15).'px;">
              '.$result->title.'
            </div>
            </a>
            ';
          $i++;
        }
      ?>
    </div>
  </div><br>

  <div id = "welcome-browse-block-indv">
    <div class = "mt-block-title-left">
      <a href = "/browse/movies/1">Movies</a>
    </div>
    <div id = "welcome-browse-block-body">
      <?php
        $results = DB::select('select * from media where category = ? 
          order by id desc limit 4', array('Movies'));
        
        $i = 0;
        foreach($results as $result) {
          echo '
            <a href = "/media/'.$result->id.'">
            <div class = "home-img-border" style="left:'.(($i * 175) + 15).'px;">
              <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
            </div>
            <div class = "home-title-box" style="left:'.(($i * 175) + 15).'px;">
              '.$result->title.'
            </div>
            </a>
            ';
          $i++;
        }
      ?>
    </div>
  </div><br>

  <div id = "welcome-browse-block-indv">
    <div class = "mt-block-title-left">
      <a href = "/browse/tv/1">TV Shows</a>
    </div>
    <div id = "welcome-browse-block-body">
      <?php
        $results = DB::select('select * from media where category = ? 
          order by id desc limit 4', array('TV Shows'));
        
        $i = 0;
        foreach($results as $result) {
          echo '
            <a href = "/media/'.$result->id.'">
            <div class = "home-img-border" style="left:'.(($i * 175) + 15).'px;">
              <img class = "home-img" src="'.Media::getThumbnail($result->id, $result->extension).'">
            </div>
            <div class = "home-title-box" style="left:'.(($i * 175) + 15).'px;">
              '.$result->title.'
            </div>
            </a>
            ';
          $i++;
        }
      ?>
    </div>
  </div><br>
@stop