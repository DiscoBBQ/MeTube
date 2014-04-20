@extends('gate')

@section('title')
  Sign in
@stop

@section('content')
	{{ Form::open(array('route' => 'signin', 'class' => 'entry_form gateway_form', 'id'=> 'signin_form' )) }}
		<h2 class="block-title">Sign in</h2>
		<div class="form_content">
			<label for="email">Email:</label><input type = "text" name = "email"><br>
			<label for="password">Password:</label><input type = "password" name = "password"><br>
			<div id="form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="account-login"></span> Sign in</button>
      </div>
		</div>
	{{ Form::close() }}
@stop