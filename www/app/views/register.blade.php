@extends('gate')

@section('title')
  Register
@stop

@section('error-explanation')
The following errors prevented you from registering
@stop

@section('content')
  <div class = "block-title">
    Register
  </div>
  <div class = "mt-form-box">
    @include('partials.error-messages', array('error_messages' => $error_messages))
  	{{ Form::open(array('route' => 'create_user')) }}
      E-mail: {{Form::email('email')}}<br>
      Channel Name: {{Form::text('channel_name')}}<br>
      Password: <input type = "password" name = "password"><br>
      Confirm Password: <input type = "password" name = "password_confirm"><br>
      <div class = "mt-form-submit-body">
        <input type = "submit" class = "mt-form-submit" value = "REGISTER">
      </div>
    {{ Form::close() }}
  </div>
@stop