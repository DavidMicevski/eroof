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
        <input type="text" id="type" name="type" value="google" style="display: none;">
        <input type="text" id="address" name="address" style="display: none;">
    </form>
    <div id="measureModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #259ad7">
                <span class="close" style="padding-top: 15px">&times;</span>
                <h3 style="color: #fff; padding-top: 0px">Set the Scale for Your Image</h3>
            </div>
            <div class="model-body">
                <div class="col-md-7" style="padding-right: 0px">
                    <div class="col-md-12" id="google-map" style="height: 245px">
                    </div>
                    <div id="scale" style="display: none;">
                        <div id="scale-value"></div>
                        <div id="scale-bar"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <p style="margin-top: 15px">Switch Providers</p>
                    <div class="col-md-12" style="background-color: #f8f8f8">
                        <select>
                            <option style="background-image:url(&quot;../../../bower_components/AdminLTE/dist/img/google.png&quot;);">GoogleMap</option>
                            <option style="background-image:url(&quot;../../../bower_components/AdminLTE/dist/img/nearmap.png&quot;);">NearMap</option>
                        </select> 
                    </div>
                    <p style="margin-top: 15px">Zoom</p>
                    <div class="col-md-11">
                        <input id="range" type="range" min="13" max="20" value="13">
                        <a href="#" id="minus" style="float: left;" onclick="zoomout()"><i class="fa fa-search-minus"></i></a>
                        <a href="#" id="plus" style="float: right;" onclick="zoomin()"><i class="fa fa-search-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-offset-3 col-md-3" style="padding-right: 0px !important">
                    <a class="btn cancel cancel_btn" onclick="measureModalClose()">CANCEL</a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-primary purchase purchase_btn" onclick="measure()">START MEASURING</a>
                </div>              
            </div>
        </div>
    </div>
</div>
<div id="map" style="height: 860px"></div>
<script type="text/javascript">
    var apikey = "{{env('NEAR_KEY')}}";
    var google_lat = -33.8688, google_lng = 151.2195, near_lat = null, near_lng = null;
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
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            disableDefaultUI: true,
            zoom: 13
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
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            google_lat = lat; google_lng = lng;
            $("#coordinate").val(lat + "," + lng);
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            $("#address").val(place.name);
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

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
            infowindow.open(map, marker);
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
            console.log('Checkbox clicked! New state=' + this.checked);
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
                zoom: 13
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

    function measure() {
        $("#form").submit();
    }

    function measureModalClose() {
        measureModal.style.display = "none";
    }

    function zoomin() {
        var zoom_val = $("#range").val();
        google_map.setZoom(parseInt(zoom_val) + 1);

        zoom_val = parseInt(zoom_val) + 1;

        if (zoom_val > 20) {
            $("#plus").addClass('disable');
            return;
        }

        $("#range").attr('value', zoom_val);
    }

    function zoomout() {
        var zoom_val = $("#range").val();
        google_map.setZoom(parseInt(zoom_val) - 1);

        zoom_val = parseInt(zoom_val) - 1;

        if (zoom_val < 13) {
            $("#minus").addClass('disable');
            return;
        }        

        $("#range").attr('value', zoom_val);
    }

    $("#range").change(function(e) {
        var zoom_val = $("#range").val();
        google_map.setZoom(parseInt(zoom_val));
    });


</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&libraries=places&callback=initMap" async defer></script>
@endsection
