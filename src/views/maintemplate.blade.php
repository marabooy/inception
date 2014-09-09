<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Human Mobility - IBM Research | Africa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/hm/css/flat-ui.css" rel="stylesheet">

    <link rel="stylesheet" href="bower_components/js/rickshaw/rickshaw.css"/>
    <link href="bower_components/leaflet/dist/leaflet.css" rel="stylesheet" type="text/css"/>
    <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"          type="text/css"/>
    <link href="http://jdewit.github.io/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.0/leaflet.awesome-markers.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/maps-fix.css"/>
    <style>
        @import url('https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css');

        .padding-30 {
            padding-top: 30px;
        }

        #map {
            height: 400px;
            width: 100%;
        }

        html, body {
            height: 100%;
        }

        .fill {
            padding: 0px;
            min-height: 100%;
            height: 100%;
            width: 100%;
            min-width: 100%;
        }

        .fill-height {
            padding: 0px;
            min-height: 100%;
            height: 100%;

        }

        body {
            padding-top: 40px; /*for navbar*/
            -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
            -moz-box-sizing: border-box; /* Firefox, other Gecko */
            box-sizing: border-box; /* Opera/IE 8+ */
        }

        .charts-container {
            float: left;
            position: relative;
        }

        .charts-container > .body {
            left: 40px;
            position: relative;
        }

        .charts-container > .yaxis {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 40px;
        }

        .legend {
            display: inline-block;
            vertical-align: top;
            margin: 0 0 0 10px;

        }


    </style>

    <link href="//vjs.zencdn.net/4.6/video-js.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/4.6/video.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
        <div class='container'>
            The Living Road Network (Nairobi, Kenya)
        </div>
    </div>
</div>

<div class="container">
    <div class="row padding-30">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Road Quality</div>


                <div class="panel-body">
                    <div id="map"></div>

                </div>
                <!--<script src="geodistance.js"></script>-->


            </div>
        </div>
    </div>
    <div class="row padding-30">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Probe Vehicle</div>
                <div class="panel-body">

                    <video id='demo' class="col-md-12">
                        <source src="data/hillcrest_demo_VP8.webm" type="video/webm">
                    </video>


                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Mobile Phone Sensors</div>
                <div class="panel-body">

                     <div class="charts-container clearfix col-md-12 ">
                        <div class="legend col-md-offset-1" id="accelerometer-yaxis">
                            <span>Accelerometer (m/s<sup>2</sup>)</span>
                            <span style="color:rgb(40, 43, 255)">x</span>
                            <span style="color:rgb(255, 127, 14)">y</span>
                            <span style="color:rgb(0,255,127)">z</span>

                        </div>
                        <div id="accelerometer-chart">
                            <canvas id="accelerometer" height="120px" width="250px"></canvas>
                        </div>
                    </div>

                    <div class="charts-container col-md-12  clearfix">
                        <span>Speed (km/h)</span>

                        <div class="legend col-md-offset-1" id="speed-yaxis">
                            <span style="color: red">linear velocity</span>

                        </div>
                        <div id="speed-chart">
                            <canvas id="speed" height="120px" width="250px"></canvas>
                        </div>
                    </div>

                    <div class="charts-container col-md-12  clearfix">
                        <span>Gyroscope (rad/s)</span>

                        <div class="legend col-md-offset-1" id="gyroscope-yaxis">
                            <span style="color:rgb(31, 119, 180)">x</span>
                            <span style="color:rgb(44, 160, 44)">y</span>
                            <span style="color:rgb(152, 223, 138)">z</span>
                        </div>
                        <div id="gyroscope-chart ">
                            <canvas id="gyroscope" height=" 120px" width="250px"></canvas>


                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>


</div>

<script src="http://code.jquery.com/jquery-1.11.0.js"></script>

<!-- /.container -->
<script>

    var initialGps;
    var speedText = $('#speed-text');
    speedText.text(0);
    var distanceDiv = $("#distance");
    distanceDiv.text(0);

</script>

<!-- Load JS here for greater good =============================-->
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="app/request-animation-polyfill.js"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/bootstrap-switch.js"></script>
<script src="js/flatui-checkbox.js"></script>
<script src="js/flatui-radio.js"></script>
<script src="js/jquery.tagsinput.js"></script>
<script src="js/jquery.placeholder.js"></script>

<script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>

<script src="http://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.0/leaflet.awesome-markers.js"></script>
<!--<script src="js/potholes-snapped.js"></script>-->
<script src="js/leaflet.awesome-markers.js"></script>
<script src="js/leaflet.groupedlayercontrol.js"></script>

<!--<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>-->
<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->


<!--<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>-->
<!--<script src="http://jdewit.github.io/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.0/leaflet.awesome-markers.js"></script>-->
<script src="app/geodistance.js"></script>

<script src="LeafletPlayback-master/LeafletPlayback-master/dist/LeafletPlayback.js"></script>
<script src="data/demo-tracks.js"></script>
<script src="app/demo_classifier_LR_results2.js"> </script>
<script src="app/SpeedAccFuelOut_v02.js"> </script>
<script src="js/potholes-snapped.js"></script>

<!--<script src="LeafletPlayback-master/LeafletPlayback-master/dist/LeafletPlayback.js"></script>-->
<!--<script src="LeafletPlayback-master/LeafletPlayback-master/data/demo/demo-tracks.js"></script>-->
<!--<script src="LeafletPlayback-master/LeafletPlayback-master/examples/example_2_control.js"></script>-->
<!--<script src="js/road_distress.js"></script>-->
<!--<script src="app/app.js"></script>-->
<script src="app/smoothie.js"></script>
<script src="app/papa.min.js"></script>
<script src="app/smoothie-charts.js"></script>
<script src="bower_components/flot/jquery.flot.js"></script>
<script>


    var stepSize = 0;
    var startTime;
    var digestCycle = false;
    var toggle = false;
    var mediaElement = document.getElementById('demo');


    var globalCopyOfEvents = [];
    var eventsQueue = [];


    $("#play-pause").click(function () {

        console.log('data');
        if (!toggle) {
            play();
            toggle = !toggle;
        } else {
            toggle = !toggle;
            pause();
        }
    });


    function play() {
//        Returns the ending time (in seconds)
//        mediaElement.currentTime = 122; // Seek to 122 seconds
        mediaElement.play();

//      max number of timers on main thread


        function drawFunction() {
            if (digestCycle) {
                return;
            }

            digestCycle = true;
//            var func = undefined;
            var slice = [];
            for (var i = 0; i < 20; i++) {


                if (eventsQueue.length != 0) {
                    var row = eventsQueue.shift();
                    var delta = row.time - startTime;

                    slice.push({row: row, delta: delta});
                    if (i == 19) {
//                        func = drawFunction;

                        setTimeout((function (row, delta) {
                            drawSlice(slice);
//                        addAccelerometerData(row.accelerometer, timeDelta)
//                        addAGyroscopeData(row.gyroscope, timeDelta)


                            digestCycle = false;
                            drawFunction();

                        })(row, delta), parseInt(delta));
                    }
                }

            }


        }


        var parser = Papa.parse("hillcrest_demo__Sensor_record_20140728_140329_AndroSensor.csv", {
            download: true,
            worker: true,
            step: function (row) {

                var time = row.data[0][28];

                var gpsData = {};
                gpsData.lat = row.data[0][20];
                gpsData.lng = row.data[0][21];

                if (isNaN(startTime) && !isNaN(parseInt(time))) {
                    startTime = time;

//                    drawFunction();
                    gpsData.lat = row.data[0][20];
                    gpsData.lng = row.data[0][21];
                    initialGps = gpsData;
                    requestAnimationFrame(drawFunction)
//                    setTimeout(drawFunction, 1000 / 60);
                }

                var accelerometerData = {x: row.data[0][0], y: row.data[0][1], z: row.data[0][2]};
                var gyroscopeData = {x: row.data[0][9], y: row.data[0][10], z: row.data[0][11]};
                var linearSpeed = {data: row.data[0][23]};

                var scheduleData = {
                    gyroscope: gyroscopeData,
                    accelerometer: accelerometerData,
                    speed: linearSpeed,
                    time: time,
                    location: gpsData
                };
                globalCopyOfEvents.push(scheduleData);
                eventsQueue.push(scheduleData);
            },
            complete: function () {
                console.log("All done!",globalCopyOfEvents.length);
            },
            delimiter: ";",
            header: false


        })
    }


    function videoPlayerSeek(time) {

        eventsQueue = globalCopyOfEvents.slice(0);
        var index = findIndexOfTimedEvent(time);
        eventsQueue.splice(index)
        console.log(eventsQueue.length);


    }

    function findIndexOfTimedEvent(time) {
        for (var i = 0; i < eventsQueue.length; i++) {
            if (eventsQueue[i].time == time) {
                return i;
            }
        }
    }
</script>
<!--placed here to allow for video control-->
<script src="app/example_2_control.js"></script>
<script src="app/example_2.js"></script>

</body>
</html>