<!doctype html>
<html>
  <head>
    <title>MeTube</title>
    <link href = "/css/common.css" rel = "stylesheet" type = "text/css">
  </head>

  <body>
    <div id = "header">
      <div id = "logo">
        <a href = "/"><img src = "/images/logo1.png"></a>
      </div>
      <div id = "search">
        {{ Form::open(array('url' => 'MeTubeController@search', 'method' => 'get'))}}
          {{ Form::text('string','',array('id' => 'searchbar', 'placeholder' => "Cat Videos")) }}
          {{ Form::button('Search', array('type' => 'submit', 'id' => 'searchbutton'))}}
        {{ Form::close() }}
      </div>
    </div>
    <div id = "sidebar">
      <div class = "sidebar-block">
        <div class = "sidebar-block-title">
          @if(Auth::check())
            <span id='username-title'>{{ Auth::user()->username }}</span>
          @else
            User
          @endif
        </div>
        <div class = "sidebar-block-body">
          @if(Auth::check())
            <a class="sidebar-block-action" href="/">Uploaded</a>
            <a class="sidebar-block-action" href="/">Downloaded</a>
            <a class="sidebar-block-action" href="/">Viewed</a>
            <a class="sidebar-block-action" href="/">Favorited</a>
            <a class="sidebar-block-action" id='signout' href = "/signout">Sign Out</a>
          @else
            <a class="sidebar-block-action" id='signin' href = "/signin">Sign In</a>
            <a class="sidebar-block-action" id='register' href = "/register">Register</a>
          @endif
        </div>
      </div>
      <div class = "sidebar-block">
        <div class = "sidebar-block-title"><span>Browse</span></div>
        <div class = "sidebar-block-body">
          <a class="sidebar-block-action" href="/">Music</a>
          <a class="sidebar-block-action" href="/">Sports</a>
          <a class="sidebar-block-action" href="/">Gaming</a>
          <a class="sidebar-block-action" href="/">Education</a>
          <a class="sidebar-block-action" href="/">Movies</a>
          <a class="sidebar-block-action" href="/">TV Shows</a>
          <a class="sidebar-block-action" href="/">News</a>
        </div>
      </div>
      <div class = "sidebar-block">
        <div class = "sidebar-block-title"> <span>Playlists</span> </div>
        <div class = "sidebar-block-body">
          <a class="sidebar-block-action" href="/">To do</a>
          <a class="sidebar-block-action" href="/">To do</a>
          <a class="sidebar-block-action" href="/">To do</a>
        </div>
      </div>
    </div>
    <div id = "container">
      @yield('content')
    </div>
  </body>
</html>