@extends("inception::template.bootstrap")


@section("head")
Playback Mode
@stop

@section('styles')
@parent
    <link rel="stylesheet" href="/bower_components/nprogress/nprogress.css" />
    <link rel="stylesheet" href="/bower_components/nvd3/nv.d3.min.css" />
@stop

@section('body')
    @include('inception::visualization.partials._reactivegraphs')
@stop

@section('scripts')
@parent
<script src="/bower_components/d3/d3.js"></script>
<script src="/bower_components/nvd3/nv.d3.js"></script>
<script src="/bower_components/nprogress/nprogress.js"></script>
<script src="/bower_components/leaflet/dist/leaflet.js"></script>
<script src="/bower_components/moment/moment.js"></script>
<script src="/app/js/canvasjs.min.js"></script>
<script src="/bower_components/papa-parse/papaparse.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/sockjs-client/0.3.4/sockjs.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/stomp.js/2.3.3/stomp.js"></script>
<script src="/app/js/reactive.js"></script>
<script>
    // Create a client instance

 Stomp.WebSocketClass = SockJS;

 var username = "humanmob",
     password = "humanmob",
     vhost    = "/",
     url      = 'http://' + 'codegladiators.com' + ':15674/stomp',
     queue    = "/queue/humob"; // To translate mqtt topics to
     					     // stomp we change slashes
     					     // to dots

  var ws = new SockJS(url);
  var client = Stomp.over(ws);
  client.heartbeat.outgoing = 0;
  client.heartbeat.incoming = 0;

 function on_connect() {
   window.console.log(client);
   client.subscribe(queue, on_message);
 }

 function on_connection_error() {
    window.console.log("error!..... error!")
 }

 function on_message(m) {
//    console.log(m);

    var values = Papa.parse(m.body);
    console.log(values);
    fillUp(values.data[0]);

//   console.log('Received:' + m);
 }



 window.onload = function () {
   // Connect

   initCharts();

     client.connect(
     username,
     password,
     on_connect,
     on_connection_error,
     vhost
   );
 }

</script>


@stop
