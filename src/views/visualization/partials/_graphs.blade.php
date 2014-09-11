
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
                           <div id="chart" style="height: 300px; width: 100%;"></div>
                         {{--<canvas id="accelerometer" height="120px" width="250px"></canvas>--}}
                     </div>
                 </div>

                 <div class="charts-container col-md-12  clearfix">
                     <span>Speed (km/h)</span>

                     <div class="legend col-md-offset-1" id="speed-yaxis">
                         <span style="color: red">linear velocity</span>

                     </div>
                     <div id="speed-chart">
                         <div id="speed" style="height: 300px; width: 100%;"></div>
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
