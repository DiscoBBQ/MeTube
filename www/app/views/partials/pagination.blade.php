<div class="page-bar">
  @if($current_page > 1)
    <a href="{{ route($route_name, array_merge($params, array('page' => ($current_page - 1)))) }}">&lt;</a>
  @endif

  <?php
    $min = 0;

    if ($current_page - 5 > 0) {
      $min = $current_page - 5;
    }

    $max = $count/6;
    if ($current_page + 5 < $count/6) {
      $max = $current_page + 5;
    }
  ?>

  @for($i = $min; $i < $max; $i++)
    <a href="{{route($route_name, array_merge($params, array('page' => ($i+1)))) }}">{{ $i + 1}}</a>
  @endfor

  @if($current_page < $count/6)
    <a href="{{ route($route_name, array_merge($params, array('page' => ($current_page + 1)))) }}">&gt;</a>
  @endif
</div>