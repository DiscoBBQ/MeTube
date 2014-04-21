@if(isset($error_messages) && count($error_messages > 0))
  <div class="errors">
    <p> @yield('error-explanation', 'The following errors occured') </p>
    <ul>
    @foreach($error_messages as $error)
      <li>{{{$error}}}</li>
    @endforeach
    </ul>
  </div>
@endif