<div id = "welcome-browse-block-indv">
  <div class = "mt-block-title-left">
    <a href="{{route('media', array('id' => $media->getID()))}}">{{$media->title}}</a>
  </div>
  <div id='welcome-browse-block-body'>
    <a href="{{route('media', array('id' => $media->getID()))}}">{{$media->title}}
      <div class = "browse-img-border">
        <img class = "browse-img" src="{{asset($media->getThumbnail())}}">
      </div>
    </a>

    <div id = "welcome-browse-block-info">
      Author: <a class = "text-link" href = "{{ route('profile', array('id' => $media->getAuthor()->getID())) }}">{{$media->getAuthor()->channel_name}}</a><br>
      Category: <a class = "text-link" href = "{{ route('browse_category', array('category' => $media->category, 'page' => 1)) }}">{{$media->category}}</a><br>
      Description: {{ $media->description }}

      @yield('playlist-ordering','')
    </div>
  </div>
</div><br/>