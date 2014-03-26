@section('content')

  <div class = "sidebar-block-title">Sign In</div>
  <div class = "mt-form-box">
    {{Form::open(array('action' => 'AuthenticationController@authenticate'))}}
      {{ Form::label('username', 'Username') }}
      {{ Form::text('username') }} <br/>

      {{ Form::label('password', 'Password') }}
      {{ Form::password('password') }} <br/>

      <div class = "mt-form-submit-body">
        {{ Form::submit("Sign In", array('class' => 'my-form-submit')) }}
      </div>
    {{Form::close()}}
  </div>

@stop