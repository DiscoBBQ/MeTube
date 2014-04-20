@section('title')
  Edit Profile
@stop

@section('error-explanation')
The following errors prevented the profile from being updated
@stop

@section('content')
  {{Form::open(array('route' => 'update_profile', 'class' => 'entry_form', 'id' => 'edit_prpfile'))}}
    <h2 class="block-title">Edit Profile</h2>
    @include('partials.error-messages', array('error_messages' => $error_messages))
    <div class="form_content">
      <label for="email">Email:</label> {{Form::email('email', $user->email)}}<br>
      <label for="channel_name">Channel Name:</label> {{Form::text('channel_name', $user->channel_name)}}<br>
      <div id="password-change">
        <label for="current_password">Current Password:</label><input type = "password" name = "current_password"><br>
        <label for="password">New Password:</label><input type = "password" name = "password"><br>
        <label for="password_confirm">Confirm New Password:</label><input type = "password" name = "password_confirm"><br>
      </div>
      <div id = "form_actions">
        <button type="submit" class="form-button"><span class="oi" data-glyph="circle-check"></span> Update Profile</button>
        <button type="reset" class="form-button"><span class="oi" data-glyph="circle-x"></span> Reset Form</button>
      </div>
    </div>
  {{Form::close()}}
    </div>
  </div>
@stop