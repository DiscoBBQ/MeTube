@extends('gate')

@section('content')
  <div class = "mt-block-title">
    Register
  </div>
  <div class = "mt-form-box">
  	{{ Form::open(array('route' => 'create_user')) }}
      Username: <input type = "text" name = "username"><br>
      Password: <input type = "password" name = "password"><br>
      Confirm Password: <input type = "password" name = "password_confirm"><br>
      E-mail: <input type = "text" name = "email"><br>
      <div class = "mt-form-submit-body">
        <input type = "submit" class = "mt-form-submit" value = "REGISTER">
      </div>
    {{ Form::close() }}
  </div>
@stop