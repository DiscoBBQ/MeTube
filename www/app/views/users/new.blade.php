@section('content')
  <div class = "sidebar-block-title"><span>Register</span></div>
  <div class = "mt-form-box">
  {{Form::open(array('action' => 'UserController@create'))}}
    {{ Form::label('username', 'Username') }}
    {{ Form::text('username') }} <br/>

    {{ Form::label('email', 'Email') }}
    {{ Form::email('email') }} <br/>

    {{ Form::label('password', 'Password') }}
    {{ Form::password('password') }} <br/>

    {{ Form::label('password_confirm', 'Confirm Password') }}
    {{ Form::password('password_confirm') }} <br/>

    <div class = "mt-form-submit-body">
      {{ Form::submit("Register", array('class' => 'my-form-submit')) }}
    </div>
  {{ Form::close() }}
  </div>
@stop