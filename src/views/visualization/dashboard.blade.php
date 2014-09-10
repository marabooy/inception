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
                        <span class="lead text-center">No Data</span>
                        </div>

                    </div>
            </div>
         </div>
    </div>
    <div class="row padding-30">
        <div class="col-md-12">
              <div class="panel panel-default">
                     <div class="panel-heading">Accelerometer</div>
                        <div class="panel-body">
                                    <div id="chart">
                                    </div>
                        </div>
              </div>
               <div class="panel panel-default">
                     <div class="panel-heading">Speed</div>
                        <div class="panel-body">
                                    <div id="speed">
                                    </div>
                        </div>
              </div>
        </div>
    </div>



@stop

@section('scripts')
@parent
<script src="/bower_components/d3/d3.js"></script>
<script src="/bower_components/crossfilter/crossfilter.js"></script>
<script src="/bower_components/dcjs/dc.js"></script>
<script src="/bower_components/nprogress/nprogress.js"></script>
<script src="/bower_components/leaflet/dist/leaflet.js"></script>
<script src="/app/js/dashboard.graphs.js"></script>
<script src="/app/js/dashboard.js"></script>

@stop
