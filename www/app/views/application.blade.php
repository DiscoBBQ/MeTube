<!doctype html>
<html>
  <head>
    <title>MeTube</title>
    <link href = "{{ asset('public/css/common.css')}}" rel = "stylesheet" type = "text/css">

    <code>
      <script src="{{ asset('public/js/jquery.js')}}"></script>
      <script src="{{ asset('public/mejs/mediaelement-and-player.min.js')}}"></script>
      <link rel="stylesheet" href="{{ asset('public/mejs/mediaelementplayer.css')}}" />
      <link rel="stylesheet" href="{{ asset('public/mejs/mejs-skins.css')}}" />
    </code>

    <script>
      jQuery(document).ready(function(){        

          // THE MOST HATED PIECE OF CODE IN THE WORLD.
          jQuery('video,audio').mediaelementplayer({
              success: function(player, node) {

              // STARTS THE VIDEO IF IT'S FLASH VIDEO FALLBACK.
              jQuery('.mejs-overlay-button').trigger('click');

              // STARTS THE VIDEO IF IT'S HTML5 COMPATIBLE.
              player.play();
              }
          });

          // FADES IN TITLES.
          // jQuery(".enter_logo").delay(2200).animate({opacity:1},2000);
          // jQuery(".enter_button").delay(6000).animate({opacity:0.4},2000);

      });
    </script>
  </head>

  <body>
    <div id = "mt-container">
      <div id = "mt-header" class>
        <div id = "mt-header-logo">
          <a href = "{{route('home')}}"><img src = "{{asset('public/images/logo1.png')}}"></a>
        </div>
        <div id = "mt-header-content">
          {{ Form::open(array('route' => 'start_search')) }}
            <input id = "mt-header-content-searchbar" type = "text" name = "phrase"> 
            <input id = "mt-header-content-searchbutton" type = "submit">
              <img src = "{{asset('public/images/search.png')}}">
            </input>
          {{ Form::close() }}
        </div>
        <div id = "mt-header-signin">
          @if(Auth::check())
            <a class = "button" href = "{{route('signout')}}">
              SIGN OUT
            </a>
            &nbsp;
            <a class = "button" href = "{{route('new_media')}}">
              UPLOAD
            </a>
          @else
            <a class = "button" href = "{{route('signin_form')}}">
              SIGN IN
            </a>
            &nbsp;
            <a class = "button" href = "{{route('register')}}">
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
            <a href = "{{ route('browse_category', array('category' => 'music')) }}"><div class = "mt-sidebar-block-button">Music</div></a>
            <a href = "{{ route('browse_category', array('category' => 'sports')) }}"><div class = "mt-sidebar-block-button">Sports</div></a>
            <a href = "{{ route('browse_category', array('category' => 'gaming')) }}"><div class = "mt-sidebar-block-button">Gaming</div></a>
            <a href = "{{ route('browse_category', array('category' => 'education')) }}"><div class = "mt-sidebar-block-button">Education</div></a>
            <a href = "{{ route('browse_category', array('category' => 'movies')) }}"><div class = "mt-sidebar-block-button">Movies</div></a>
            <a href = "{{ route('browse_category', array('category' => 'tv')) }}"><div class = "mt-sidebar-block-button">TV Shows</div></a>
          </div>
        </div>
        @if(Auth::check())
          <br>
          <div class = "mt-sidebar-block">
            <div class = "mt-block-title"> USER </div>
            <div class = "mt-sidebar-block-body">
              <a href = "{{ route('profile', array('id' => Auth::user()->getAuthIdentifier())) }}"><div class = "mt-sidebar-block-button">Profile</div></a>
              <a href="{{route('messages')}}"><div class = "mt-sidebar-block-button">Messages</div></a>
              <a href = "{{ route('my_subscriptions') }}"><div class = "mt-sidebar-block-button">My Subscriptions</div></a>
              <a href = "{{ route('uploaded', array('id' => Auth::user()->getAuthIdentifier())) }}"><div class = "mt-sidebar-block-button">Uploaded</div></a>
              <a href = "{{ route('downloaded', array('id' => Auth::user()->getAuthIdentifier())) }}"><div class = "mt-sidebar-block-button">Downloaded</div></a>
              <a href = "{{ route('viewed', array('id' => Auth::user()->getAuthIdentifier())) }}"><div class = "mt-sidebar-block-button">Viewed</div></a>
              <a href = "{{ route('favorited', array('id' => Auth::user()->getAuthIdentifier())) }}"><div class = "mt-sidebar-block-button">Favorited</div></a>
            </div>
          </div>
          <br>
          <div class = "mt-sidebar-block">
            <div class = "mt-block-title"> PLAYLISTS </div>
            <div class = "mt-sidebar-block-body">
              <a href = "{{route('new_playlist')}}"><div class = "mt-sidebar-block-button">Create Playlist</div></a>
              <?php
                $result = DB::select("SELECT * FROM playlist WHERE user_id = ? ORDER BY id", array(Auth::user()->id));
                foreach($result as $playlist) {
                  echo '<a href = "' . route('playlist', array('id' => $playlist->id)) .'"><div class = "mt-sidebar-block-button">'.$playlist->title.'</div></a>';
                }
              ?>
            </div>
          </div>
        @endif
      </div>
      <div id='mt-welcome'>
        @yield('content')
      </div>
    </div>
  </body>
</html>