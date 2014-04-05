{{ Form::open(array('route' => array('add_comment_to_media', $media->getID()))) }}
  <center>
    <textarea name = "comment" rows = '4' cols = '50'></textarea>
  </center>
  <input type = "submit" class = "mt-form-submit" value = "COMMENT">
{{ Form::close() }}