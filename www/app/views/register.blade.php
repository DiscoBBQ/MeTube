@extends('gate')

@section('title')
  Register
@stop

@section('error-explanation')
The following errors prevented you from registering
@stop

@section('content')
  {{ Form::open(array('route' => 'create_user', 'class' => 'entry_form gateway_form', 'id' => 'register')) }}
    <h2 class="block-title">Register</h2>
    @include('partials.error-messages', array('error_messages' => $error_messages))
    <div class="form_content">
      <label for="email">E-mail:</label>{{Form::email('email')}}<br>
      <label for="channel_name">Channel Name:</label>{{Form::text('channel_name')}}<br>
      <label for="password">Password:</label><input type = "password" name = "password"><br>
      <label for="password_confirm">Confirm Password:</label><input type = "password" name = "password_confirm"><br>
      <div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Register</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
    </div>
  {{ Form::close() }}
@stop