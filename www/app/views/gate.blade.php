<!doctype html>
<html>
  <head>
    <title>MeTube: @yield('title', "CPSC 462 Project")</title>
    <link href = "{{ asset('public/css/common.css')}}" rel = "stylesheet" type = "text/css">
  </head>
  <body>
    <div id = "container">
      <div id = "header">
        <div id = "logo">
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