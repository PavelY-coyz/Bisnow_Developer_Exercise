@extends('layouts.app')

@section('content')
<style>
img {
    max-width: 100%;
    max-height: 100%;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="/news/{{$current->id}}">{{$current->title}}</a></div>
                <div class="panel-body" id="panel-body-news">
                  <?php
                    $html_body = base64_decode($current->html_body);
                    $html_body = str_replace('/|', '>', $html_body);
                    $html_body = str_replace('|', '<', $html_body);
                    print $html_body;
                  ?>
                </div>
            </div>

            <nav class="align-center">
              <ul class="pagination ">
                <li class="page-item {{(is_null($previous) ? 'disabled' : '') }}">
                  <a class="page-link" href="{{ (is_null($previous) ? '' : $previous->id) }}">Previous</a></li>
                <li class="page-item {{(is_null($next) ? 'disabled' : '') }}">
                  <a class="page-link" href="{{ (is_null($next) ? '' : $next->id) }}">Next</a></li>
              </ul>
            </nav>
        </div>
    </div>
</div>

<script type="text/javascript">
function trackVisit() {
    $.ajax({
      type: "POST",
      url: "trackVisit",
      async: true,
      cache: false,
      data: ({
          'url' : 'news/{{$item_id}}',
          'item_id' : '{{ isset($item_id) ? $item_id : '0' }}' ,
          'item_type' : '{{ $item_type }}'
          <?php //we dont need to send anything else through ajax. Everything else will be in the session/request ?>
      }),
      success: function(result) {
          console.log("success on ajax");
          console.log(result);
      },
      error: function(data, etype) {
          console.log("error on ajax");
          console.log(data);
          console.log(etype);
      }
    });
}
document.ready=trackVisit();
</script>
@endsection
