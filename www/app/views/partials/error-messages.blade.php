<div class="errors">
  @if(isset($error_messages) && count($error_messages > 0))
    <p> @yield('error-explanation', 'The following errors occured') </p>
    <ul>
    @foreach($error_messages as $error)
      <li>{{$error}}</li>
    @endforeach
    </ul>
  @endif
</div>