<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Analyser</title>
        <link rel="stylesheet" href="bower_components/leaflet/dist/leaflet.css"/>
        <style>
            #map {
                height: 300px;
            }
        </style>
    </head>
<body>
        <div id="map"></div>
        <div id="results"></div>
<a href="" class="more-details">Link</a>
<script src="bower_components/jquery/dist/jquery.min.js" ></script>
<script src="bower_components/leaflet/dist/leaflet.js"></script>

<script>

    var markers =[];
    var map = L.map('map').setView([36.8167, -1.2833], 8);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18
    }).addTo(map);


    function onMapClick(e) {
//        gib_uni();
       var marker = new L.marker(e.latlng);
        marker.on('dragend', function(event){
                var marker = event.target;
                var position = marker.getLatLng();
                alert(position);
                marker.setLatLng([position],{draggable:'true'}).bindPopup(position).update();
        });
        map.addLayer(marker);

        markers.push(marker);
        if(markers.length >= 2){
            if(markers.length>2){

             var markerToDelete=    markers.shift();
             map.removeLayer(markerToDelete);
             }
            makeThatCall(markers);
        }
    };

    map.on('click',onMapClick);


    function makeThatCall(markers){

    var values = [markers[0].getLatLng(),markers[1].getLatLng()];
    var query= [
         [
            values[0].lng,
            values[0].lat
        ],
        [
            values[1].lng,
            values[1].lat
        ]
        ];
//    console.log(query);

        $.ajax({
        method:'POST',
        dataType: "json",
        url: '/search',
        contentType : 'application/json',
        data: JSON.stringify(query),
        success: function(response){
                createList(response);
                console.log(response);
           }
        });


//

    }


     function createList(elements){
            var html;
            var list = "";
            for(var i=0;i< elements.hits.hits.length;i++){
                    var element = elements.hits.hits[i];
                    list+="<li> " +
                     "<span class='more-details' href=\"/search/document/"+element._type+"/"+element._id+"\">"+element._id+"</span></li>";
                    console.log(element);
            }

            if(elements.hits.hits.length==0){
             html= "<strong>No data found</strong>";
            }else{
               html= "<ul class=\"list-unstyled\">\n "+list+"  \n</ul>";
            }

            console.log(html);
            $('#results').append(html);

        }

        $('#result').on('click','.more-details',function(){
            console.log(this);
            return false;
        });

</script>
</body>
</html>