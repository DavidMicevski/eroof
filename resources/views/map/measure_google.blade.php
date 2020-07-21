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
    <div class="panel panel-default" style="border-top: none; background-color: #f8f8f8; ">
        <div id="map" class="panel-body">
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('map.real') }}">
            {{ csrf_field() }}
            <div id="button-panel" class="col-md-12" style="margin-top: 20px; margin-bottom: 20px">
                <div id="scale" class="col-md-2">
                    <div id="scale-value">

                    </div>
                    <div id="scale-bar">

                    </div>
                </div>
                <div class="col-md-1 col-md-offset-3">
                    <a class="btn cancel" style="width: 100%; margin-right: 0" href="{{ route('map.user_upload') }}">Cancel</a>
                </div>
                <div class="col-md-1">
                    <button name="subject" class="btn btn-primary customer_btn" type="submit">Confirm</button>
                </div>
            </div>
            <input id="coordinate" type="text" name="coordinate" style="display: none;">
            <input id="type" type="text" name="type" value="google" style="display: none;">
        </form>
    </div>
</div>
<script src="https://cdn.klokantech.com/maptilerlayer/v1/index.js"></script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/leaflet.draw.js') }}"></script>
<script src="{{ asset('js/label.js') }}"></script>
<script type="text/javascript">
    var map;
    var minScaleWidth = 50;
    var maxScaleWidth = 80;
    var markers = [];
    var lat = {{$lat}}, lng = {{$lng}};
    var coordinate, zoomLevel;
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

    $( document ).ready(function() {
        var height = $(window).height() - $("#button-panel").height()*2 - 40 - $(".main-header").height();
        $("#map").height(height);
    });

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: lat,
                lng: lng
            },
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            disableDefaultUI: true,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_LEFT
            },
            gestureHandling: 'greedy',
            zoom: 20
        });

        var marker = new google.maps.Marker({
            position: map.getCenter(),
            icon: {
                url: '{{ asset("/bower_components/AdminLTE/dist/img/pointer.png") }}',
                labelOrigin: new google.maps.Point(25, 70)
            },
            map: map,
            label: {
                text: "Confirm Roof Location",
                color: "white",
                fontWeight: "bold",
                fontSize: "16px",
            }
        });
        markers.push(marker);

        zoomLevel = map.getZoom();
        coordinate = lat + "," + lng + "," + zoomLevel + "";
        $("#coordinate").val(coordinate);

        google.maps.event.addDomListener(map, 'zoom_changed', function() {
            lat = map.getCenter().lat();
            lng = map.getCenter().lng();

            zoomLevel = map.getZoom();
            coordinate = lat + "," + lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);

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
                label: {
                    text: "Confirm Roof Location",
                    color: "white",
                    fontWeight: "bold",
                    fontSize: "16px"
                }
            });

            markers.push(marker);
        });

        google.maps.event.addListener(map, 'dragend', function() { 
            lat = map.getCenter().lat();
            lng = map.getCenter().lng();

            zoomLevel = map.getZoom();
            coordinate = lat + "," + lng + "," + zoomLevel + "";
            $("#coordinate").val(coordinate);

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
                label: {
                    text: "Confirm Roof Location",
                    color: "white",
                    fontWeight: "bold",
                    fontSize: "16px"
                }
            });

            markers.push(marker);
        });

        google.maps.event.addListener(map, 'idle', makeScale);
    }

    function makeScale() {
        let zoom = map.getZoom();
        let scale = 156543.03392 * Math.cos(map.getCenter().lat() * Math.PI / 180) / Math.pow(2, zoom);

        let minScale = Math.floor(scale * minScaleWidth);
        let maxScale = Math.ceil(scale * maxScaleWidth);
        for (var i = 0; i < scaleValues.length; i++) {
            if (i !== scaleValues.length - 1) {
                if (((minScale <= scaleValues[i].val) && (scaleValues[i].val <= maxScale)) || ((minScale > scaleValues[i].val) && (maxScale) < scaleValues[i + 1].val)) {

                    setScaleValues(scale, scaleValues[i]);

                    break;
                }
            } else {
                setScaleValues(scale, scaleValues[i]);
            }
        }
    }

    function setScaleValues(scale, values) {
        let scaleWidth = values.val / scale;
        document.getElementById('scale-bar').style.width = scaleWidth + 'px';
        document.getElementById('scale-value').innerHTML = values.dspVal;

        coordinate = lat + "," + lng + "," + zoomLevel + "," + scaleWidth + "," + values.dspVal;
        $("#coordinate").val(coordinate);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&libraries=places&callback=initMap" async defer></script>
@endsection
