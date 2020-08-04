@extends('map.base')

@section('action-content')
<style type="text/css">
    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
        width: 100%;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }
</style>
<div class="row">
    <div class="panel panel-default">
        <div class="col-md-12">
            <input class="form-control" id="pac-input" type="text" placeholder="Enter a location">
        </div>
    </div>
     <form id="form" class="form-horizontal" role="form" method="POST" action="{{ route('map.real') }}">
        {{ csrf_field() }}
        <input id="coordinate" name="coordinate" type="text" name="" value="" style="display: none;">
        <input type="text" id="type" name="type" style="display: none;">
        <input type="text" id="address" name="address" style="display: none;">
    </form>
    <div id="measureModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #259ad7">
                <span class="close" style="padding-top: 15px">&times;</span>
                <h3 style="color: #fff; padding-top: 0px">Set the Scale for Your Image</h3>
            </div>
            <div class="model-body">
                <div class="col-md-7" id="google-body" style="padding-right: 0px">
                    <div class="col-md-12" id="google-map" style="height: 245px">
                    </div>
                    <div id="scale" style="display: none;">
                        <div id="scale-value"></div>
                        <div id="scale-bar"></div>
                    </div>
                </div>
                <div class="col-md-7" id="near-body" style="padding-right: 0px; display: none;">
                    <div class="col-md-12" id="near-map" style="height: 245px">
                    </div>
                    <div id="scale" style="display: none;">
                        <div id="scale-value"></div>
                        <div id="scale-bar"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <p style="margin-top: 15px">Switch Providers</p>
                    <div class="col-md-12" style="background-color: #f8f8f8">
                        <select id="selectmap" style='width: 200px;' onchange="selectmap()">
                            <option value="google">Google Map</option>
                            <option value="near">Near Map</option>
                        </select>
                    </div>
                    <p style="margin-top: 15px">Zoom</p>
                    <div class="col-md-11">
                        <input id="range" type="range" min="13" max="20" value="20">
                        <a href="#" id="minus" style="float: left;" onclick="zoomout()"><i class="fa fa-search-minus"></i></a>
                        <a href="#" id="plus" style="float: right;" onclick="zoomin()"><i class="fa fa-search-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-offset-3 col-md-3" style="padding-top: 10px; padding-right: 0px !important">
                    <a class="btn cancel cancel_btn" onclick="measureModalClose()">CANCEL</a>
                </div>
                <div class="col-md-4" style="padding-top: 10px;">
                    <a class="btn btn-primary purchase purchase_btn" onclick="measure()">START MEASURING</a>
                </div>              
            </div>
        </div>
    </div>
</div>
<div id="map" style="height: 860px"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
<script type="text/javascript">
    $("#selectmap").select2({
        templateResult: formatState
    });
    var apikey = "{{env('NEAR_KEY')}}"; 
    var google_lat = 43.653226, google_lng = -79.3831843, near_lat = 43.653226, near_lng = -79.3831843;
    var minScaleWidth = 50;
    var maxScaleWidth = 80;
    var coordinate, zoomLevel;
    var google_map = null, near_map = null;
    var markers = [];
    var scaleValues = [{
        val: 2,
        dspVal: '2 m'
    }, {
        val: 5,
        dspVal: '5 m'
    }, {
        val: 10,
        dspVal: '10 m'
    }, {
        val: 20,
        dspVal: '20 m'
    }, {
        val: 50,
        dspVal: '50 m'
    }, {
        val: 100,
        dspVal: '100 m'
    }, {
        val: 200,
        dspVal: '200 m'
    }, {
        val: 500,
        dspVal: '500 m'
    }, {
        val: 1000,
        dspVal: '1 km'
    }, {
        val: 2000,
        dspVal: '2 km'
    }, {
        val: 5000,
        dspVal: '5 km'
    }, {
        val: 10000,
        dspVal: '10 km'
    }, {
        val: 20000,
        dspVal: '20 km'
    }, {
        val: 50000,
        dspVal: '50 km'
    }, {
        val: 100000,
        dspVal: '100 km'
    }, {
        val: 200000,
        dspVal: '200 km'
    }, {
        val: 500000,
        dspVal: '500 km'
    }, {
        val: 1000000,
        dspVal: '1000 km'
    }, {
        val: 2000000,
        dspVal: '2000 km'
    }, {
        val: 5000000,
        dspVal: '5000 km'
    }
];

    function initMap() {
        var myStyles =[
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [
                      { visibility: "off" }
                ]
            }
        ];
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            disableDefaultUI: true,
            gestureHandling: 'greedy',
            zoom: 13,
            styles: myStyles 
        });

        var marker = new google.maps.Marker({
            position: map.getCenter(),
            icon: {
                url: '{{ asset("/bower_components/AdminLTE/dist/img/pointer.png") }}',
                labelOrigin: new google.maps.Point(25, 70)
            },
            map: map,
        });
        markers.push(marker);

        google.maps.event.addDomListener(map, 'zoom_changed', function() {
            for(i=0; i<markers.length; i++){
                markers[i].setMap(null);
            }
            var marker = new google.maps.Marker({
                position: map.getCenter(),
                icon: {
                    url: '{{ asset("/bower_components/AdminLTE/dist/img/pointer.png") }}',
                    labelOrigin: new google.maps.Point(25, 70)
                },
                map: map,
            });
            markers.push(marker);
        });

        google.maps.event.addListener(map, 'dragend', function() { 
            for(i=0; i<markers.length; i++){
                markers[i].setMap(null);
            }
            var marker = new google.maps.Marker({
                position: map.getCenter(),
                icon: {
                    url: '{{ asset("/bower_components/AdminLTE/dist/img/pointer.png") }}',
                    labelOrigin: new google.maps.Point(25, 70)
                },
                map: map,
            });
            markers.push(marker);
        });

        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        // var marker = new google.maps.Marker({
        //     map: map,
        //     anchorPoint: new google.maps.Point(0, -29)
        // });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            // marker.setVisible(false);
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            google_lat = lat; google_lng = lng;
            near_lat = lat; near_lng = lng;
            $("#coordinate").val(lat + "," + lng);
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            $("#address").val($("#pac-input").val());
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(20);
            }
            // marker.setPosition(place.geometry.location);
            // marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            // infowindow.open(map, marker);
        });

        function setupClickListener(id, types) {
            var radioButton = document.getElementById(id);
            radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
            });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
        .addEventListener('click', function() {
            autocomplete.setOptions({strictBounds: this.checked});
        });

        
    }

    var measureModal = document.getElementById("measureModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        if (measureModal.style.display == "block")
            measureModal.style.display = "none";
    }

    $(document).ready(function(){
        $("#confirm_image").click(function() {
            measureModal.style.display = "block";

            google_map = new google.maps.Map(document.getElementById("google-map"), {
                center: {
                    lat: google_lat,
                    lng: google_lng
                },
                mapTypeId: google.maps.MapTypeId.SATELLITE,
                disableDefaultUI: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                gestureHandling: 'greedy',
                zoom: 20
            });

            coordinate = google_lat + ',' + google_lng + "," + google_map.getZoom() + "";

            $("#coordinate").val(coordinate);

            google.maps.event.addDomListener(google_map, 'zoom_changed', function() {
                google_lat = google_map.getCenter().lat();
                google_lng = google_map.getCenter().lng();

                zoomLevel = google_map.getZoom();
                coordinate = google_lat + "," + google_lng + "," + zoomLevel + "";
                $("#coordinate").val(coordinate);
            });

            google.maps.event.addListener(google_map, 'dragend', function() { 
                google_lat = google_map.getCenter().lat();
                google_lng = google_map.getCenter().lng();

                zoomLevel = google_map.getZoom();
                coordinate = google_lat + "," + google_lng + "," + zoomLevel + "";
                $("#coordinate").val(coordinate);
            });

            google.maps.event.addListener(google_map, 'idle', makeScaleGoogle);

            google.maps.event.addListener(map, 'idle', makeScaleGoogle);

        ///////-Near Map
        if (apikey === undefined || apikey.length === 0) {
            alert('Please provide your Nearmap API Key');
            return;
        }

        var map_types=[
            createMapType(256, 256, 0, 'Vert'),
            createMapType(256, 181, 0, 'N'),
            createMapType(256, 181, 90, 'E'),
            createMapType(256, 181, 180, 'S'),
            createMapType(256, 181, 270, 'W'),
        ];

        var mapOptions = {
            zoom: 20,
            center: {
                lat: near_lat,
                lng: near_lng
            },
            disableDefaultUI: true,
            gestureHandling: 'greedy',
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'Vert', 'N', 'E', 'S', 'W']
            }
        };
        near_map = new google.maps.Map(document.getElementById('near-map'), mapOptions);

        google.maps.event.addDomListener(near_map, 'zoom_changed', function() {
            near_lat = near_map.getCenter().lat();
            near_lng = near_map.getCenter().lng();

            zoomLevel = near_map.getZoom();
            coordinate = near_lat + "," + near_lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);
        });

        google.maps.event.addListener(near_map, 'dragend', function() { 
            near_lat = near_map.getCenter().lat();
            near_lng = near_map.getCenter().lng();

            zoomLevel = near_map.getZoom();
            coordinate = near_lat + "," + near_lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);
        });

        google.maps.event.addListener(near_map, 'idle', makeScaleNear);

        for(var i=0; i<map_types.length; i++){
            var mt = map_types[i];
            near_map.mapTypes.set(mt.name, mt);
        }

        registerProjectionWorkaround(near_map);

        near_map.setMapTypeId('Vert');
        });

        if ($("#selectmap").val() == "google") {
            $("#type").val("google");
            $("#near-body").css({
                'display': 'none'
            });
        } else {
            $("#type").val("near");
            $("#google-body").css({
                'display': 'none'
            });
        }

        $("#range").change(function() {
            if ($("#selectmap").val() == "google") {
                google_map.setZoom(parseInt($("#range").val()));
            } else {
                near_map.setZoom(parseInt($("#range").val()));
            }
        });
    });

    $("#form").on("keypress", function (event) { 
        var keyPressed = event.keyCode || event.which; 
        if (keyPressed === 13) { 
            event.preventDefault(); 
            return false; 
        } 
    }); 

    function makeScaleGoogle() {
        let zoom = google_map.getZoom();
        $("#range").val(zoom);
        let scale = 156543.03392 * Math.cos(google_map.getCenter().lat() * Math.PI / 180) / Math.pow(2, zoom);

        let minScale = Math.floor(scale * minScaleWidth);
        let maxScale = Math.ceil(scale * maxScaleWidth);
        for (var i = 0; i < scaleValues.length; i++) {
            if (i !== scaleValues.length - 1) {
                if (((minScale <= scaleValues[i].val) && (scaleValues[i].val <= maxScale)) || ((minScale > scaleValues[i].val) && (maxScale) < scaleValues[i + 1].val)) {

                    setScaleValuesGoogle(scale, scaleValues[i]);

                    break;
                }
            } else {
                setScaleValuesGoogle(scale, scaleValues[i]);
            }
        }
    }

    function setScaleValuesGoogle(scale, values) {
        let scaleWidth = values.val / scale;
        document.getElementById('scale-bar').style.width = scaleWidth + 'px';
        document.getElementById('scale-value').innerHTML = values.dspVal;

        coordinate = google_lat + ',' + google_lng + "," + google_map.getZoom() + "," + scaleWidth + "," + values.dspVal;
        $("#coordinate").val(coordinate);
    }

    function makeScaleNear() {
        let zoom = near_map.getZoom();
        $("#range").val(zoom);
        let scale = 156543.03392 * Math.cos(near_map.getCenter().lat() * Math.PI / 180) / Math.pow(2, zoom);

        let minScale = Math.floor(scale * minScaleWidth);
        let maxScale = Math.ceil(scale * maxScaleWidth);
        for (var i = 0; i < scaleValues.length; i++) {
            if (i !== scaleValues.length - 1) {
                if (((minScale <= scaleValues[i].val) && (scaleValues[i].val <= maxScale)) || ((minScale > scaleValues[i].val) && (maxScale) < scaleValues[i + 1].val)) {

                    setScaleValuesNear(scale, scaleValues[i]);

                    break;
                }
            } else {
                setScaleValuesNear(scale, scaleValues[i]);
            }
        }
    }

    function setScaleValuesNear(scale, values) {
        let scaleWidth = values.val / scale;
        document.getElementById('scale-bar').style.width = scaleWidth + 'px';
        document.getElementById('scale-value').innerHTML = values.dspVal;

        coordinate = near_lat + ',' + near_lng + "," + near_map.getZoom() + "," + scaleWidth + "," + values.dspVal;
        $("#coordinate").val(coordinate);
    }

    function degreesToRadians(deg) {
        return deg * (Math.PI / 180);
    }

    function radiansToDegrees(rad) {
        return rad / (Math.PI / 180);
    }

    function regionForCoordinate(x, y, zoom) {
        var x_z1 = x / Math.pow(2, (zoom - 1));
        if (x_z1 < 1) {
            return 'us';
        } else {
            return 'au';
        }
    }

    function rotateTile(coord, zoom, heading) {
        var numTiles = 1 << zoom; // 2^zoom
        var x, y;

        switch(heading){
            case 0:
                x = coord.x;
                y = coord.y;
                break;
            case 90:
                x = numTiles - (coord.y + 1);
                y = coord.x;
                break;
            case 180:
                x = numTiles - (coord.x + 1);
                y = numTiles - (coord.y + 1);
                break;
            case 270:
                x = coord.y;
                y = numTiles - (coord.x + 1);
                break;
        }
        return new google.maps.Point(x, y);
    }

    function MercatorProjection(worldWidth, worldHeight){
        this.pixelOrigin = new google.maps.Point(worldWidth / 2, worldHeight / 2);
        this.pixelsPerLonDegree = worldWidth / 360;
        this.pixelsPerLatRadian = worldHeight / (2 * Math.PI);
    }

    MercatorProjection.prototype.fromLatLngToPoint=function(latlng, opt_point) {
        var point = opt_point || new google.maps.Point(0, 0);
        var origin = this.pixelOrigin;

        var lat = latlng.lat();
        var lng = latlng.lng();

        point.x = origin.x + lng * this.pixelsPerLonDegree;
        var siny = Math.sin(degreesToRadians(lat));
        point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) *
        -this.pixelsPerLatRadian;

        return point;
    };

    MercatorProjection.prototype.fromPointToLatLng = function(point, noWrap) {
        var origin = this.pixelOrigin;

        var lng = (point.x - origin.x) / this.pixelsPerLonDegree;
        var latRadians = (point.y - origin.y) / -this.pixelsPerLatRadian;
        var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) - Math.PI / 2);

        return new google.maps.LatLng(lat, lng);
    };

    const projVertical = new MercatorProjection(256, 256);

    function vertToWest(ll) {
        var pt = projVertical.fromLatLngToPoint(ll);
        pt = new google.maps.Point(pt.y, pt.x);
        ll = projVertical.fromPointToLatLng(pt);
        return new google.maps.LatLng(ll.lat(), -ll.lng());
    }

    function westToVert(ll) {
        ll = new google.maps.LatLng(ll.lat(), -ll.lng());
        var pt = projVertical.fromLatLngToPoint(ll);
        pt = new google.maps.Point(pt.y, pt.x);
        return projVertical.fromPointToLatLng(pt);
    }

    function vertToEast(ll) {
        var pt = projVertical.fromLatLngToPoint(ll);
        pt = new google.maps.Point(pt.y, pt.x);
        ll = projVertical.fromPointToLatLng(pt);
        return new google.maps.LatLng(-ll.lat(), ll.lng());
    }

    function eastToVert(ll) {
        ll = new google.maps.LatLng(-ll.lat(), ll.lng());
        var pt = projVertical.fromLatLngToPoint(ll);
        pt = new google.maps.Point(pt.y, pt.x);
        return projVertical.fromPointToLatLng(pt);
    }

    function fakeLatLng(mapTypeId, ll) {
        if (mapTypeId === 'W') {
            ll = vertToWest(ll);
        } else if (mapTypeId === 'E') {
            ll = vertToEast(ll);
        } else if (mapTypeId === 'S') {
            ll = new google.maps.LatLng(-ll.lat(), -ll.lng());
        }
        return ll;
    }

    function realLatLng(mapTypeId, ll) {
        if (mapTypeId === 'W') {
            ll = westToVert(ll);
        } else if (mapTypeId === 'E') {
            ll = eastToVert(ll);
        } else if (mapTypeId === 'S') {
            ll = new google.maps.LatLng(-ll.lat(), -ll.lng());
        }
        return ll;
    }

    function registerProjectionWorkaround(map) {
        var currMapType = near_map.getMapTypeId();

        near_map.addListener('maptypeid_changed', function() {
            var center = realLatLng(currMapType, near_map.getCenter());
            currMapType = near_map.getMapTypeId();
            near_map.setCenter(fakeLatLng(currMapType, center));
        });
    }

    function createMapType(tileWidth, tileHeight, heading, name){
        var maptype = new google.maps.ImageMapType({
            name: name,
            tileSize: new google.maps.Size(tileWidth, tileHeight),
            isPng: true,
            minZoom: 1,
            maxZoom: 24,
            getTileUrl: function(coord, zoom) {
            coord = rotateTile(coord, zoom, heading);

            var x = coord.x;
            var y = coord.y;
            var url = 'http://'+ regionForCoordinate(x, y, zoom) +
                '0.nearmap.com/maps/hl=en' +
                '&x=' + x +
                '&y=' + y +
                '&z=' + zoom +
                '&nml=' + name + '&httpauth=false&version=2' +
                '&apikey=' + apikey;
                return url;
            }
        });
        maptype.projection = new MercatorProjection(tileWidth, tileHeight);
        return maptype;
    }

    function measure() {
        $("#form").submit();
    }

    function measureModalClose() {
        measureModal.style.display = "none";
    }

    function zoomin() {
        var zoom_val = parseInt($("#range").val());
        zoom_val += 1;
        if ($("#selectmap").val() == "google") {
            google_map.setZoom(zoom_val);
        } else {
            near_map.setZoom(zoom_val);
        }

        if (zoom_val > 20) {
            $("#plus").addClass('disable');
            return;
        }

        $("#range").attr('value', zoom_val);
    }

    function zoomout() {
        var zoom_val = parseInt($("#range").val());
        zoom_val -= 1;
        if ($("#selectmap").val() == "google") {
            google_map.setZoom(zoom_val);
        } else {
            near_map.setZoom(zoom_val);   
        }

        if (zoom_val < 13) {
            $("#minus").addClass('disable');
            return;
        }        

        $("#range").attr('value', zoom_val);
    }

    $("#range").change(function(e) {
        var zoom_val = parseInt($("#range").val());

        if ($("#selectmap").val() == "google") {
            google_map.setZoom(zoom_val);
        } else {
            near_map.setZoom(zoom_val);   
        }
    });

    function formatState (state) {
        if (!state.id) { return state.text; }
        var $state = $(
            '<span ><img style="width: 50px; display: inline-block;" src="/bower_components/AdminLTE/dist/img/' + state.element.value.toLowerCase() + '.png" /> ' + state.text + '</span>'
        );
        return $state;
    }

    function selectmap() {
        if ($("#selectmap").val() == "google") {
            $("#type").val("google");
            $("#near-body").css({
                'display': 'none'
            });
            $("#google-body").css({
                'display': 'block'
            });
            $("#range").attr('value', 13);
        } else {
            $("#type").val("near");
            $("#google-body").css({
                'display': 'none'
            });
            $("#near-body").css({
                'display': 'block'
            });
            $("#range").attr('value', 13);
        }
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&libraries=places&callback=initMap" async defer></script>
@endsection
