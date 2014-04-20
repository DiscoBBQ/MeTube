<!doctype html>
<html>
  <head>
    <title>MeTube: @yield('title', "CPSC 462 Project")</title>
    <link href = "{{ asset('public/css/common.css')}}" rel = "stylesheet" type = "text/css">
    <link href = "{{ asset('public/css/open-iconic.css')}}" rel = "stylesheet" type = "text/css">
  </head>
  <body>
    <div id = "container">
      <div id = "header">
        <div id = "logo">
          <a href = "{{route('home')}}"><img src = "{{asset('public/images/logo1.png')}}"></a>
        </div>
      </div>

      <div id="gate-content">
        @yield('content')
      </div>
    </div>
  </body>
</html>