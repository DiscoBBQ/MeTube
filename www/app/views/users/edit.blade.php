@section('title')
  Edit Profile
@stop

@section('error-explanation')
The following errors prevented the profile from being updated
@stop

@section('content')
  <div id = "mt-upload-inner">
    <div class = "mt-block-title">Upload</div>
      <div class = "mt-form-box">
        @include('partials.error-messages', array('error_messages' => $error_messages))
        {{Form::open(array('route' => 'update_profile'))}}
          E-mail: {{Form::email('email', $user->email)}}<br>
          Channel Name: {{Form::text('channel_name', $user->channel_name)}}<br>
          <div id="password-change">
            Current Password: <input type = "password" name = "current_password"><br>
            New Password: <input type = "password" name = "password"><br>
            Confirm New Password: <input type = "password" name = "password_confirm"><br>
          </div>
          <div class = "mt-form-submit-body">
            <input type = "submit" class = "mt-form-submit" value = "Update Profile">
          </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
@stop