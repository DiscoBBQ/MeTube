@section('content')
  @foreach($subscriptions as $subscription)
    <?php $subscription_user = $subscription->getSubscriptionUser(); ?>
    <?php $recent_media = Media::getUploadedByUserID($subscription_user->getID()) ?>
    <?php $recent_media = array_slice($recent_media, 0, 4) ?>
    <div class='subscription'>
      <div class="header">
        <span class="title">{{ $subscription_user->channel_name }}</span>
        <span class="unsubscribe">
          <a href = "{{route('unsubscribe_from_user', array('id' => $subscription_user->getID()))}}" class = "button">UNSUBSCRIBE</a>
        </span>
      </div>
      <div class="media">
        @foreach($recent_media as $media)
          @include('media.preview-block', array('media' => $media))
        @endforeach
        <a href="{{route('uploaded', array('userid' => $subscription_user->getID()))}}">View More</a>
      </div>
    </div>
  @endforeach

@stop