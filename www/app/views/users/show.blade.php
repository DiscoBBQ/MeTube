@section('title')
  Channel - {{$user->channel_name}}
@stop

@section('content')
<div id="profile">
  <h2>{{{ $user->channel_name }}}</h2>
  <div id = "profile-links">
    @if(Auth::check())
      @if(Subscription::isUserSubscribedToThisUser(Auth::user()->getAuthIdentifier(), $user->getID()))
        <a href = "{{route('unsubscribe_from_user', array('id' => $user->getID()))}}" class = "button"><span class="oi" data-glyph="minus"></span>Unsubscribe</a>
      @else
        <a href = "{{route('subscribe_to_user', array('id' => $user->getID()))}}" class = "button"><span class="oi" data-glyph="plus"></span>Subscribe</a>
      @endif
    @endif
    <a class="text-link" href = "{{route('uploaded', array('id' => $user->getID()))}}">
      <span class="oi" data-glyph="data-transfer-upload"></span>Uploaded</a> |
    <a class="text-link" href = "{{route('downloaded', array('id' => $user->getID()))}}">
      <span class="oi" data-glyph="data-transfer-download"></span>Downloaded</a> | 
    <a class="text-link" href = "{{route('viewed', array('id' => $user->getID()))}}">
      <span class="oi" data-glyph="eye"></span>Viewed</a> | 
    <a class="text-link" href = "{{route('favorited', array('id' => $user->getID()))}}">
      <span class="oi" data-glyph="star"></span>Favorited</a>
  </div>
  <h3>Recent Uploads</h3>
  <?php $medias = Media::getUploadedByUserID($user->getID()); ?>
  <?php $medias = array_slice($medias, 0, 4); ?>
  @if(count($medias) <= 0)
    <p class="no-media">No media uploaded by the channel yet.</p>
  @endif
  @foreach ($medias as $media)
    @include('media.preview-block', array('media' => $media))
  @endforeach
  <a class="button" href="{{route('uploaded', array('userid' => $user->getID()))}}"><span class="oi" data-glyph="list-rich"></span>View More</a>
</div>

@stop