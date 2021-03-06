@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Home page for the Bisnow developer exercise
                </div>
            </div>
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
          'url' : 'home',
          'item_id' : '{{ isset($item_id) ? $item_id : '0' }}' ,
          'item_type' : 'home'
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
