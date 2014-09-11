@extends("inception::template.bootstrap")


@section("head")
Visualization
@stop

@section('styles')
@parent
    <link rel="stylesheet" href="/bower_components/nprogress/nprogress.css" />
    <link rel="stylesheet" href="/bower_components/dcjs/dc.css" />
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
                 <div class="panel-heading">Results</div>
                    <div class="panel-body">
                        <div id="results">
                        <ul class="list-unstyled"></ul>
                        <span class="lead text-center no-data">No Data</span>
                        </div>

                    </div>
            </div>
         </div>
    </div>
    <div class="row padding-30">
        <div class="col-md-12">
              <div class="panel panel-default col-md-6">
                        <div class="panel-body">
                                    <div id="chart" style="width: 100%; height: 300px">
                                    </div>
                        </div>
              </div>
               <div class="panel panel-default col-md-6">
                        <div class="panel-body">
                                    <div id="speed" style="width: 100%; height: 300px">
                                    </div>
                        </div>
              </div>
              <div class="panel panel-default">
                        <div class="panel-body">
                                    <div id="gyro" style="width: 100%; height: 300px">
                                    </div>
                        </div>
              </div>
        </div>
    </div>



@stop

@section('scripts')
@parent
{{--<script src="/bower_components/d3/d3.js"></script>--}}
{{--<script src="/bower_components/crossfilter/crossfilter.js"></script>--}}
{{--<script src="/bower_components/dcjs/dc.js"></script>--}}
<script src="/bower_components/moment/moment.js"></script>
<script src="/app/js/canvasjs.min.js"></script>
<script src="/bower_components/nprogress/nprogress.js"></script>
<script src="/bower_components/leaflet/dist/leaflet.js"></script>
<script src="/app/js/dashboard.graphs.js"></script>
<script src="/app/js/dashboard.js"></script>

@stop
