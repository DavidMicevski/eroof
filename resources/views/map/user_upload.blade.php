@extends('map.base')

@section('action-content')
<style type="text/css">
    a[href^="http://maps.google.com/maps"]{display:none !important}
    a[href^="https://maps.google.com/maps"]{display:none !important}

    .gmnoprint a, .gmnoprint span, .gm-style-cc {
        display:none;
    }
</style>
<div class="row">
    <div class="panel panel-default" style="border-top: none;">
        <div class="panel-body">
            <form id="real_form" class="form-horizontal" role="form" method="POST" action="{{ route('map.real') }}">
                {{ csrf_field() }}
                <div class="col-md-2 col-md-offset-1 upload-manual-image">
                    <div class="col-md-12" id="google-map" style="height: 245px">
                    </div>
                    <div id="scale" style="display: none;">
                        <div id="scale-value">

                        </div>
                        <div id="scale-bar">

                        </div>
                    </div>
                    <div class="col-md-12 header">
                        <i class="icon icon-draw float-left mr-3" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/google.png") }}&quot;) center center no-repeat; border:1px solid #ccc; font-size:30px;background-size: 25px!important"></i>    
                        <p class="title">Google Map</p>
                        <p class="price">Free</p>
                    </div>
                    <div class="col-md-12 term">
                        <p>Accepted file formats: jpeg, png</p>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <button name="subject" class="btn btn-primary customer_btn" type="button" onclick="setType('google')">Draw it myself</button>
                    </div>
                </div>

                <div class="col-md-2 col-md-offset-1 upload-manual-image">
                    <div class="col-md-12" id="near-map" style="height: 245px">
                    </div>
                    <div id="scale" style="display: none;">
                        <div id="scale-value">

                        </div>
                        <div id="scale-bar">

                        </div>
                    </div>
                    <div class="col-md-12 header">
                        <i class="icon icon-draw float-left mr-3" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/nearmap.png") }}&quot;) center center no-repeat; border:1px solid #ccc; font-size:30px;background-size: 25px!important"></i>    
                        <p class="title">Near Map</p>
                        <p class="price">Free</p>
                    </div>
                    <div class="col-md-12 term">
                        <p>Accepted file formats: jpeg, png</p>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <button name="subject" class="btn btn-primary customer_btn" type="button" onclick="setType('near')">Draw it myself</button>
                    </div>
                </div>


                <div class="col-md-2 col-md-offset-1 upload-manual-image">
                    <img id="after_input_img" src="{{ asset("/bower_components/AdminLTE/dist/img/upload-to-cloud.png") }}" style="max-height: 245px;">
                    <div class="col-md-12 header">
                        <i class="icon icon-draw float-left mr-3" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/draw-icon.svg") }}&quot;) center center no-repeat; border:1px solid #ccc; font-size:30px;background-size: 25px!important"></i>    
                        <p class="title">Upload Image</p>
                        <p class="price">Free</p>
                    </div>
                    <div class="col-md-12 term">
                        <p>Accepted file formats: jpeg, png</p>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <a class="btn btn-primary" onclick="uploadImg()" style="width: 100%">
                        Browse</a>    
                    </div>
                </div>
                <input id="coordinate" type="text" name="coordinate" style="display: none;">
                <input id="type" type="text" name="type" style="display: none;">
                <input id="type" type="text" name="address" value="{{$address}}" style="display: none;">
            </form>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('map.measure_google') }}">
                {{ csrf_field() }}
                <input id="coordinate1" type="text" name="coordinate1" style="display: none;">
                <input type="submit" id="google" name="" style="display: none;">
            </form>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('map.measure_near') }}">
                {{ csrf_field() }}
                <input id="coordinate2" type="text" name="coordinate2" style="display: none;">
                <input type="submit" id="near" name="" style="display: none;">
            </form>
            <div class="col-md-12 image-select-bottom-title">
                <span>Purchase premium images for Do-It-Yourself measurements</span>
            </div>

            <div class="col-md-4 col-md-offset-4 image-select-bottom-button">
                <a class="btn cancel" href="{{ route('map.create') }}" style="width: 40%">Cancel</a>
            </div>
            <input type="file" id="input_file" name="" style="display: none;">
            <a id="go_page" href="{{ route('map.action') }}" style="display: none;"></a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script type="text/javascript">
    var apikey = "{{env('NEAR_KEY')}}";
    var google_lat = {{$lat}}, google_lng = {{$lng}}, near_lat = {{$lat}}, near_lng = {{$lng}};
    var minScaleWidth = 50;
    var maxScaleWidth = 80;
    var coordinate, zoomLevel;
    var google_map = null, near_map = null;
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
        ////////////////////Google Map///////////////////////////////////
        google_map = new google.maps.Map(document.getElementById("google-map"), {
            center: {
                lat: google_lat,
                lng: google_lng
            },
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            disableDefaultUI: true,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            gestureHandling: 'greedy',
            zoom: 20
        });

        coordinate = google_lat + ',' + google_lng + "," + google_map.getZoom() + "";

        $("#coordinate").val(coordinate);
        $("#coordinate1").val(coordinate);

        var controlTrashUI = document.createElement('a');
        controlTrashUI.innerHTML = '<i class="fa fa-edit" style="border: none; width: 0px; height: 0px; margin-top: 10px; color: black"></i>';
        controlTrashUI.style.cursor = 'pointer';
        controlTrashUI.style.height = '28px';
        controlTrashUI.style.width = '25px';
        controlTrashUI.style.top = '11px';
        controlTrashUI.style.left = '150px';
        controlTrashUI.title = 'Adjust map center';
        google_map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlTrashUI);

        controlTrashUI.addEventListener("click", function () {
            $("#google").click();
        });

        google.maps.event.addDomListener(google_map, 'zoom_changed', function() {
            google_lat = google_map.getCenter().lat();
            google_lng = google_map.getCenter().lng();

            zoomLevel = google_map.getZoom();
            coordinate = google_lat + "," + google_lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);
            $("#coordinate1").val(coordinate);
        });

        google.maps.event.addListener(google_map, 'dragend', function() { 
            google_lat = google_map.getCenter().lat();
            google_lng = google_map.getCenter().lng();

            zoomLevel = google_map.getZoom();
            coordinate = google_lat + "," + google_lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);
            $("#coordinate1").val(coordinate);
        });

        google.maps.event.addListener(google_map, 'idle', makeScaleGoogle);
        ////////////////////End Google Map///////////////////////////////////

        ////////////////////Near Map///////////////////////////////////
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
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            gestureHandling: 'greedy',
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'Vert', 'N', 'E', 'S', 'W']
            }
        };
        near_map = new google.maps.Map(document.getElementById('near-map'), mapOptions);

        var controlTrashUI = document.createElement('a');
        controlTrashUI.innerHTML = '<i class="fa fa-edit" style="border: none; width: 0px; height: 0px; margin-top: 10px; color: black"></i>';
        controlTrashUI.style.cursor = 'pointer';
        controlTrashUI.style.height = '28px';
        controlTrashUI.style.width = '25px';
        controlTrashUI.style.top = '11px';
        controlTrashUI.style.left = '150px';
        controlTrashUI.title = 'Adjust map center';
        near_map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlTrashUI);

        controlTrashUI.addEventListener("click", function () {
            $("#near").click();
        });

        google.maps.event.addDomListener(near_map, 'zoom_changed', function() {
            near_lat = near_map.getCenter().lat();
            near_lng = near_map.getCenter().lng();

            zoomLevel = near_map.getZoom();
            coordinate = near_lat + "," + near_lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);
            $("#coordinate2").val(coordinate);
        });

        google.maps.event.addListener(near_map, 'dragend', function() { 
            near_lat = near_map.getCenter().lat();
            near_lng = near_map.getCenter().lng();

            zoomLevel = near_map.getZoom();
            coordinate = near_lat + "," + near_lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);
            $("#coordinate2").val(coordinate);
        });

        google.maps.event.addListener(near_map, 'idle', makeScaleNear);

        for(var i=0; i<map_types.length; i++){
            var mt = map_types[i];
            near_map.mapTypes.set(mt.name, mt);
        }

        registerProjectionWorkaround(near_map);

        near_map.setMapTypeId('Vert');

        ////////////////////End Near Map///////////////////////////////////
    }
    

    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        
        var reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function () {
            fileContent = reader.result;
            $('#after_input_img').attr('src', fileContent);
            $('#after_input_img').css({
                'width' : '245px',
                'height' : '245px',
            });

            $('#go_page')[0].click();
        }
    });

    function makeScaleNear() {
        let zoom = near_map.getZoom();
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
        $("#coordinate2").val(coordinate);
    }

    function makeScaleGoogle() {
        let zoom = google_map.getZoom();
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
        $("#coordinate1").val(coordinate);
    }
    ////////////////////End Google Map///////////////////////////////////

    ////////////////////Near Map////////////////////////////////////////
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
    ////////////////////////End Near Map/////////////////////////////////////


    ////////////////////Manual Image Upload//////////////////////////////
    function uploadImg() {
        $("#input_file").click();
    }

    function setType(type) {
        if (type == 'google') {
            $("#type").val('google');
        } else if (type == 'near') {
            $("#type").val('near');
        }

        $( "#real_form" ).submit();
    }

    ////////////////////Manual Image Upload//////////////////////////////
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&libraries=places&callback=initMap" async defer></script>
@endsection
