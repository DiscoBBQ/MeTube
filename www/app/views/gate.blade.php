<!doctype html>
<html>
  <head>
    <title>MeTube - Register</title>
    <link href = "{{ asset('public/css/common.css')}}" rel = "stylesheet" type = "text/css">
  </head>
  <body>
    <div id = "mt-container">
      <div id = "mt-header" class>
        <div id = "mt-header-logo">
          <a href = "{{route('home')}}"><img src = "{{asset('public/images/logo1.png')}}"></a>
        </div>
      </div>

      <div id = "mt-signin-body">
        <div id = "mt-signin-inner">
          @yield('content')
        </div>
      </div>
    </div>
  </body>
</html>