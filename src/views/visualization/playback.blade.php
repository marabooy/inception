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

    <div class="row padding-30">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Map</div>
                <div class="panel-body">
                    <div id="map"></div>
                </div>


            </div>
        </div>
        <div class="col-md-3">
                    {{--sidebar here--}}

            <div class="panel panel-default">
                 <div class="panel-heading">Gauges</div>
                    <div class="panel-body">
                        <div id="results">
                        <ul class="list-unstyled"></ul>
                        </div>

                    </div>
            </div>
         </div>
    </div>

    @include('inception::visualization.partials._graphs')

@stop

@section('scripts')
@parent
<script src="/bower_components/d3/d3.js"></script>
<script src="/bower_components/nvd3/nv.d3.js"></script>
<script src="/bower_components/nprogress/nprogress.js"></script>
<script src="/bower_components/leaflet/dist/leaflet.js"></script>
<script src="/bower_components/moment/moment.js"></script>
<script src="/app/js/canvasjs.min.js"></script>

<script>
var geoJson = <?php echo json_encode( $geoJson) ?>;
</script>
<script src="/app/js/dashboard.js"></script>

<script src="/app/js/playback.js"></script>


@stop
