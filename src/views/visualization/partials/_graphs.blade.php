
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


                     </div>
                     <div id="accelerometer-chart">
                           <div id="chart" style="height: 300px; width: 100%;"></div>
                         {{--<canvas id="accelerometer" height="120px" width="250px"></canvas>--}}
                     </div>
                 </div>

                 <div class="charts-container col-md-12  clearfix">
                     <span>Speed (km/h)</span>


                     <div id="speed-chart">
                         <div id="speed" style="height: 300px; width: 100%;"></div>
                     </div>
                 </div>

                 <div class="charts-container col-md-12  clearfix">
                     <span>Gyroscope (rad/s)</span>


                     <div id="gyroscope-chart" style="height: 300px; width: 100%">


                     </div>
                 </div>

             </div>
         </div>
     </div>

 </div>
