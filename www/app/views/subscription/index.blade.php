@section('title')
  My Subscriptions
@stop

@section('content')
  <h2>Subscriptions</h2>
  @foreach($subscriptions as $subscription)
    <?php $subscription_user = $subscription->getSubscriptionUser(); ?>
    <?php $recent_media = Media::getUploadedByUserID($subscription_user->getID()) ?>
    <?php $recent_media = array_slice($recent_media, 0, 4) ?>
    <div class='subscription'>
      <h3 class="block-title"><a href = "{{ route('profile', array('id' => $subscription_user->getID())) }}">{{{$subscription_user->channel_name}}}</a></h3>
      <h4>Recent Uploads</h4>
      <div class="media">
        @if(count($recent_media) <= 0)
          <p class="no-media">No media uploaded by the channel yet.</p>
        @endif
        @foreach($recent_media as $media)
          @include('media.preview-block', array('media' => $media))
        @endforeach
        <a class="button" href="{{route('uploaded', array('userid' => $subscription_user->getID()))}}"><span class="oi" data-glyph="list-rich"></span>View More</a>
        <span class="unsubscribe">
          <a href = "{{route('unsubscribe_from_user', array('id' => $subscription_user->getID()))}}" class = "button"><span class="oi" data-glyph="minus"></span>Unsubscribe</a>
        </span>
      </div>
    </div>
  @endforeach

@stop