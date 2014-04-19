@section('title')
  Channel - {{$user->channel_name}}
@stop

@section('content')
<div id = "profile-links">
    <a href = "{{route('uploaded', array('id' => $user->getID()))}}">
      <span class = "">UPLOADED</span></a> | 
    <a href = "{{route('downloaded', array('id' => $user->getID()))}}">
      <span class = "">DOWNLOADED</span></a> | 
    <a href = "{{route('viewed', array('id' => $user->getID()))}}">
      <span class = "">VIEWED</span></a> | 
    <a href = "{{route('favorited', array('id' => $user->getID()))}}">
      <span class = "">FAVORITED</span></a>
  </div>
  <br>
  <div class = "sidebar-block">
    <div class = "block-title">{{$user->channel_name}}</div>
      <div class = "sidebar-block-body">
        <h2>Recent Uploads</h2>
        <?php $medias = Media::getUploadedByUserID($user->getID()) ?>
        @if(count($medias) <= 0)
          <p class="no-media">No media uploaded by the channel yet.</p>
        @endif
        @foreach ($medias as $media)
          @include('media.preview-block', array('media' => $media))
        @endforeach
      </div>
  </div>
  <br>
  <center>

    @if(Auth::check())
      @if(Subscription::isUserSubscribedToThisUser(Auth::user()->getAuthIdentifier(), $user->getID()))
        <a href = "{{route('unsubscribe_from_user', array('id' => $user->getID()))}}" class = "button">UNSUBSCRIBE</a>
      @else
        <a href = "{{route('subscribe_to_user', array('id' => $user->getID()))}}" class = "button">SUBSCRIBE</a>
      @endif
    @endif
  </center>
</div>

@stop