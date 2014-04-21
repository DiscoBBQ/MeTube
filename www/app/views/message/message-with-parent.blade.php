@if($message->getParentMessage() != NULL)
  @include('message.message-with-parent', array('message' => $message->getParentMessage()))
  <div class="message-link"></div>
@endif

@include('message.message-block', array('message' => $message))