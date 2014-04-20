@extends('gate')

@section('title')
  Sign in
@stop

@section('content')
	<div class = "block-title">Sign In</div>
	<div class = "mt-form-box">
		{{ Form::open(array('route' => 'signin')) }}
			Email: <input type = "text" name = "email"><br>
			Password: <input type = "password" name = "password"><br>
			<div class = "form-button-body">
				<input type = "submit" class = "form-button" value = "SIGN IN">
			</div>
		{{ Form::close() }}
	<div>
@stop