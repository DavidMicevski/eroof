@extends('map.base')

@section('action-content')
<div class="row">
    <div class="panel panel-default" style="border-top: none; background-color: #f8f8f8;">
        <form id="pitch_form" class="form-horizontal" role="form" method="POST" action="{{ route('map.pitch') }}">
            {{ csrf_field() }}    
            <input type="hidden" id="lat" name="lat" value="{{$lat}}">
            <input type="hidden" id="lng" name="lng" value="{{$lng}}">
        </form>
        <div id="layer-tool" class="col-md-1">
            <div class="row">
                <div class="col-md-8">
                    <button id="all" class="btn btn-primary" style="width: 100%" onclick="allLayerClick();">All Layers</button>
                    <button id="plus" class="btn btn-primary" style="width: 100%">+</button>
                    <button id="layer1" class="btn btn-primary" style="width: 100%" onclick="layer1_click();">1</button>
                    <button id="up" class="btn btn-primary" style="width: 100%">Move Up</button>
                </div>
            </div>
        </div>

        <div id="right_tool_bar" class="col-md-2">
            <div id="draw_tools">
                <div id="name" class="col-md-7">
                    <span id="tool-name">Draw Tools</span>
                </div>
                <div class="col-md-5">
                    <a id="right" href="#" onclick="hideToolbar();"><i class="fa fa-angle-right"></i></a>
                    <a id="left" href="#" onclick="showToolbar();" class="hidden"><i class="fa fa-angle-left"></i></a>
                </div>
            </div>
            <button class="col-md-12" id="normal_draw">
                <div class="col-md-11" style="line-height: 2">
                    <i class="icon icon-draw" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/draw-icon.svg") }}&quot;) center center no-repeat;"></i><span id="tool-name">Draw</span>
                </div>
            </button>
            <button class="col-md-12" id="move_anchor">
                <div class="col-md-11" style="line-height: 2">
                    <i class="icon icon-draw" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/move-cursor-icon.svg") }}&quot;) center center no-repeat;"></i>
                    <span id="tool-name">Move Anchor Point</span>
                </div>
            </button>
            <button class="col-md-12" id="delete_edge" onclick="deleteEdge()">
                <div class="col-md-9"><i class="fa fa-times-circle-o"></i><span id="tool-name">Delete Edge</span></div>
            </button>
            <button class="col-md-12" id="delete_all_edge" onclick="deleteAllEdges()">
                <div class="col-md-10"><i class="fa fa-trash-o"></i><span id="tool-name">Delete All Edges</span></div>
            </button>
            <button class="col-md-12" id="reset_scale">
                <div class="col-md-10"><i class="fa fa-times-circle-o"></i><span id="tool-name">Reset Scaling</span></div>
            </button>
            <button class="col-md-12" id="upload_img">
                <div class="col-md-10"><i class="fa fa-external-link"></i><span id="tool-name">Upload Image</span></div>
            </button>
        </div>

        <div id="right_tool_bar" class="col-md-2 edges hidden">
            <div id="draw_tools">
                <div id="name" class="col-md-7">
                    <span id="tool-name">Edges Tools</span>
                </div>
                <div class="col-md-5">
                    <a id="right" href="#" onclick="hideToolbar();"><i class="fa fa-angle-right"></i></a>
                    <a id="left" href="#" onclick="showToolbar();" class="hidden"><i class="fa fa-angle-left"></i></a>
                </div>
            </div>
            <button class="col-md-12" id="eaves" onclick="changeEdge('#71bf82')">
                <div class="col-md-9"><i class="edge" style="background-color: #71bf82"></i><span>Eaves</span></div>
            </button>
            <button class="col-md-12" id="valleys" onclick="changeEdge('#f0512e')">
                <div class="col-md-9"><i class="edge" style="background-color: #f0512e"></i><span>Valleys</span></div>
            </button>
            <button class="col-md-12" id="hips" onclick="changeEdge('#9368b7')">
                <div class="col-md-9"><i class="edge" style="background-color: #9368b7"></i><span>Hips</span></div>
            </button>
            <button class="col-md-12" id="ridges" onclick="changeEdge('#d0efb1')">
                <div class="col-md-9"><i class="edge" style="background-color: #d0efb1"></i><span>Ridges</span></div>
            </button>
            <button class="col-md-12" id="rakes" onclick="changeEdge('#ffa500')">
                <div class="col-md-9"><i class="edge" style="background-color: #ffa500"></i><span>Rakes</span></div>
            </button>
            <button class="col-md-12" id="wall" onclick="changeEdge('#4187af')">
                <div class="col-md-9"><i class="edge" style="background-color: #4187af"></i><span>Wall Flashing</span></div>
            </button>
            <button class="col-md-12" id="step" onclick="changeEdge('#ffcc0f')">
                <div class="col-md-9"><i class="edge" style="background-color: #ffcc0f"></i><span>Step Flashing</span></div>
            </button>
            <button class="col-md-12" id="transition" onclick="changeEdge('#fb68ff')">
                <div class="col-md-9"><i class="edge" style="background-color: #fb68ff"></i><span>Transition</span></div>
            </button>
            <button class="col-md-12" id="unspec" onclick="changeEdge('#55d3fc')">
                <div class="col-md-9"><i class="edge" style="background-color: #55d3fc"></i><span>Unspecified</span></div>
            </button>
            <button class="col-md-12" id="delete_edge" onclick="deleteEdge()">
                <div class="col-md-9"><i class="fa fa-times-circle-o"></i><span id="tool-name">Delete Edge</span></div>
            </button>
            <button class="col-md-12" id="delete_all_edge" onclick="deleteAllEdges()">
                <div class="col-md-10"><i class="fa fa-trash-o"></i><span id="tool-name">Delete All Edges</span></div>
            </button>
        </div>

        <div id="right_tool_bar" class="col-md-2 facets hidden">
            <div id="draw_tools">
                <div id="name" class="col-md-7">
                    <span id="tool-name">Facets Tools</span>
                </div>
                <div class="col-md-5">
                    <a id="right" href="#" onclick="hideToolbar();"><i class="fa fa-angle-right"></i></a>
                    <a id="left" href="#" onclick="showToolbar();" class="hidden"><i class="fa fa-angle-left"></i></a>
                </div>
            </div>
            <button class="col-md-12" id="delete_facet" onclick="deleteFacet()">
                <div class="col-md-9"><i class="fa fa-times-circle-o"></i><span id="tool-name">Delete Facet</span></div>
            </button>
            <button class="col-md-12" id="delete_pitch" onclick="deletePitch()">
                <div class="col-md-9"><i class="fa fa-times-circle-o"></i><span id="tool-name">Delete Pitch</span></div>
            </button>
            <button class="col-md-12" id="delete_all_edge" onclick="deleteAllPitches()">
                <div class="col-md-10"><i class="fa fa-trash-o"></i><span id="tool-name">Delete All Pitches</span></div>
            </button>
            <button class="col-md-12" id="delete_facet" onclick="changeLabelMarker('DR')">
                <span id="tool-name">Dormer</span>
            </button>
            <button class="col-md-12" id="delete_facet" onclick="changeLabelMarker('TS')">
                <span id="tool-name">Two Story</span>
            </button>
            <button class="col-md-12" id="delete_facet" onclick="changeLabelMarker('TL')">
                <span id="tool-name">Two Layer</span>
            </button>
            <button class="col-md-12" id="delete_facet" onclick="changeLabelMarker('LS')">
                <span id="tool-name">Low Slope</span>
            </button>
        </div>

        <div class="col-md-1" style="bottom: 20px; position: absolute; z-index: 3000; margin-left: 15px">
            <div class="col-md-12" style="border: 1px solid #000; padding-left: 0px; padding-right: 0px; margin-bottom: 5px; background-color: #259ad7">
                <a class="btn cancel" style="border: none; width: 47%; color: #fff; padding-left: 0; padding-right: 0" onclick="zoomin()" title="Zoom In">ZoomIn</a>
                <a class="btn cancel" style="border: none; width: 50%; color: #fff; padding-left: 0; padding-right: 0" onclick="zoomout()" title="Zoom Out">ZoomOut</a> 
            </div>
            <div class="col-md-12" style="border: 1px solid #000; padding-left: 0px; padding-right: 0px; background-color: #259ad7">
                <a class="btn cancel" style="border: none; width: 20%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateleft(-1)" title="Rotate Left (1 degree)">L1</a>
                <a class="btn cancel" style="border: none; width: 25%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateleft(-10)" title="Rotate Left (10 degrees)">L10</a>
                <a class="btn cancel" style="border: none; width: 25%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateright(10)" title="Rotate Right (10 degrees)">R10</a>
                <a class="btn cancel" style="border: none; width: 22%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateright(1)" title="Rotate Right (1 degree)">R1</a>
            </div>       
        </div>
        <div class="col-md-2" style="bottom: 20px; position: absolute; z-index: 3000; right: 0">
            <div class="col-md-12" style="border: 1px solid #000; background-color: #259ad7; margin-bottom: 5px">
                <a class="btn cancel" style="border: none; width: 47%; color: #fff" title="Cancel">Cancel</a>
                <a class="btn cancel" style="border: none; width: 50%; color: #fff" title="Save">Save</a>
            </div>
            <div class="col-md-12" style="border: 1px solid #000; background-color: #259ad7; margin-bottom: 5px">
                <a class="btn cancel" style="border: none; width: 47%; color: #fff" title="Undo">Undo</a>
                <a class="btn cancel" style="border: none; width: 50%; color: #fff" title="Redo">Redo</a>
            </div>
            <div class="col-md-12" style="border: 1px solid #000; background-color: #259ad7">
                <a class="btn cancel" style="border: none; width: 30%; color: #fff" title="Toggle Snapping">Snapping</a>
                <a class="btn cancel" style="border: none; width: 33%; color: #fff" onclick="showgrid()" title="Show Grid">Grid</a>
                <a class="btn cancel" style="border: none; width: 33%; color: #fff" onclick="crosshair()" title="Cross Hair">CrossHair</a>
            </div>
        </div>
        <div id="grid" class="col-md-12" style="pointer-events: none;"></div>
        <div id="map" class="col-md-12" style="height: 860px; background-color: green">
            <form id="download_form" class="form-horizontal" role="form" method="POST" action="{{ route('map.download') }}">
                {{ csrf_field() }}    
                <input type="hidden" id="type" name="type">
                <input type="hidden" id="real-address" name="address">
                <input type="hidden" id="total-area" name="total-area">
                <input type="hidden" id="ts" name="ts">
                <input type="hidden" id="tl" name="tl">
                <input type="hidden" id="ls" name="ls">
                <input type="hidden" id="zero_twel" name="zero_twel">
                <input type="hidden" id="one_twel" name="one_twel">
                <input type="hidden" id="two_twel" name="two_twel">
                <input type="hidden" id="three_twel" name="three_twel">
                <input type="hidden" id="four_twel" name="four_twel">
                <input type="hidden" id="five_twel" name="five_twel">
                <input type="hidden" id="six_twel" name="six_twel">
                <input type="hidden" id="seven_twel" name="seven_twel">
                <input type="hidden" id="eight_twel" name="eight_twel">
                <input type="hidden" id="nine_twel" name="nine_twel">
                <input type="hidden" id="ten_twel" name="ten_twel">
            </form>
            
            <div id="firstModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h3>Set the Scale for Your Image</h3>

                        <h5 class="align-left" style="padding-top: 20px;">Draw a line of known length to set the scale for your measurements.</h5>
                        <h5 class="align-left" style="padding-bottom: 50px;">The rest of the measurements will be adjusted automatically.</h5>

                        <div class="col-md-offset-3 col-md-3" style="padding-right: 0px !important">
                            <a class="btn cancel cancel_btn" onclick="firstModalClose()">Cancel</a>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-primary purchase purchase_btn" onclick="drawLine()">Draw a line</a>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div id="uploadModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header" style="padding-left: 36px; padding-right: 36px;">
                        <span class="close">&times;</span>
                        <h3>Upload Image</h3>

                        <h5 class="align-left" style="padding-top: 20px;">This will create a new report with the same address, and customer<br> information.</h5>

                        <div id="upload_panel">
                            <div id="upload_btn" class="col-md-4 col-md-offset-4">
                                <a class="btn btn-primary purchase purchase_btn" onclick="fileBrowse()">Browse</a>
                            </div>
                            <div class="col-md-5 col-md-offset-4" style="padding-left: 0px;">
                                <h5 class="align-center">Accepted file formats: jpeg, png</h5>
                            </div>
                            <div class="col-md-12" id="after_input_img">
                                
                            </div>
                        </div>

                        <div class="col-md-6" style="padding-right: 0px !important;">
                            <a class="btn cancel cancel_btn" onclick="uploadModalClose()">Cancel</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary purchase purchase_btn" onclick="showImage();">Submit</a>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div id="setInchModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header" style="padding-left: 36px; padding-right: 36px;">
                        <span class="close">&times;</span>
                        <h3>Set Scale for Your Image</h3>

                        <h5 class="align-left" style="padding-top: 20px;">Length of line (feet and inches)</h5>

                        <div class="col-md-6" style="padding-right: 0px !important;">
                            <input class="form-control" type="number" id="feet" name="feet" placeholder="Feet" min="1">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="number" id="inch" name="inch" placeholder="Inches" min="1" max="11">
                        </div>

                        <div class="col-md-offset-3 col-md-3" style="padding-right: 0px !important; margin-top: 30px">
                            <a class="btn cancel cancel_btn" onclick="setInchModalClose()">Cancel</a>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-primary purchase purchase_btn" onclick="setInch()" style="margin-top: 30px;">OK</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h3>This will delete all edges!</h3>

                        <h5 class="align-left" style="padding-top: 20px;">Are you sure you want to delete all edges?</h5>

                        <div class="col-md-offset-3 col-md-3" style="padding-right: 0px !important">
                            <a class="btn cancel cancel_btn" onclick="deleteModalClose()">Cancel</a>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-primary purchase purchase_btn" onclick="deleteAllEdge()">Delete all edges</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            <input type="file" name="" id="input_file" style="display: none;">
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/leaflet.draw.js') }}"></script>
<script type="text/javascript">
    var crossHairStatus = false;
    var pixelInchRatio1 = 0;
    var labelMarkers = [], changeLabelMarkerStatus = false;
    var pixel = {{$pixel}}, distance = {{$distance}}, unit = "{{$unit}}";
    if (unit == 'km') { // convert km to metre
        distance = distance * 1000;
    }
    var type = "{{$type}}";
    var pixelInchRatio = distance / pixel, pixelInchRatio1 = distance / pixel;

    var degree = 0, pitchVal = 0;
    var totalArea = 0;
    var dormerStatus = false, twolayerStatus = false, twostoryStatus = false, lowslopeStatus = false;
    var showgridStatus = false, grid = null;;
    var polylines = [], deleteEdgeStatus = false, lineColor = null, changeLineStatus = false;
    var removefacetStatus = false, setpitchStatus = false, removepitchStatus = false;;
    var layer1_lines = [], layer2_lines = [], layer3_lines = [], layer4_lines = [], layer5_lines = [];
    var layer1_polygon = [], layer2_polygon = [], layer3_polygon = [], layer4_polygon = [], layer5_polygon = [];
    var polygon = null, layer1 = [], layer2 = [], layer3 = [], layer4 = [], layer5 = [];
    var mark1 = [], mark2 = [], mark3 = [], mark4 = [], mark5 = [];
    var mark1_temp = [], mark2_temp = [], mark3_temp = [], mark4_temp = [], mark5_temp = [];
    var mark1_sp = [], mark2_sp = [], mark3_sp = [], mark4_sp = [], mark5_sp = [];
    var map = null, drawnItems = null, markers = [], drawControl = null;
    var fileName = '';
    var scrollTop = 0;
    var imgwidth = 0, imgheight = 0;
    var lastPosX = 0, lastPosY = 0;
    var wndWidth = 0, wndHeight = 0;
    var headerHeight = 0, menuWidth = 0;
    var feet = 0, inch = 0;
    var resetClicked = false, inchSetted = false;
    var fileContent = "";
    var myPolylineDrawHandler = null;
    var btn_index = 1;
    var active_index = 1;
    var la1_isClick = false, la2_isClick = false, la3_isClick = false, la4_isClick = false, la5_isClick = false;
    var drawTabStatus = true, edgeTabStatus = false, faceTabStatus = false;
    var firstModal = document.getElementById("firstModal");
    var uploadModal = document.getElementById("uploadModal");
    var setInchModal = document.getElementById("setInchModal");
    var deleteModal = document.getElementById("deleteModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        if (firstModal.style.display == "block")
            firstModal.style.display = "none";
        else if (uploadModal.style.display == "block")
            uploadModal.style.display = "none";
        else if (setInchModal.style.display == "block")
            setInchModal.style.display = "none";
        else if (deleteModal.style.display == "block")
            deleteModal.style.display = "none";
    }

    $(document).ready(function(){
        $('#address').text('{{$address}}');

        if (type == "google") {
            map = L.map('map', {
                editable: true, 
                crs: L.CRS.Simple,
                maxZoom: 3,
                minZoom: -1,
            });
            map.doubleClickZoom.disable();
            var bounds = [[0, 0], [1300, 1300]];
            var filePath = "https://maps.googleapis.com/maps/api/staticmap?center={{$lat}},{{$lng}}&zoom={{$zoom}}&size=1920x1080&maptype=satellite&key={{env('GOOGLE_IMAGE_KEY')}}";
        } else if (type == "near") {
            map = L.map('map', {
                editable: true, 
                crs: L.CRS.Simple,
                maxZoom: 3,
                minZoom: -1,
            });
            map.doubleClickZoom.disable();
            var bounds = [[0, 0], [1280, 1024]];
            var filePath = "http://us0.nearmap.com/staticmap?center={{$lat}},{{$lng}}&size=1920x1080&zoom={{$zoom}}&httpauth=false&apikey={{env('NEAR_KEY')}}";
        }

        var image = L.imageOverlay(filePath, bounds).addTo(map);
        map.fitBounds(bounds);

        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        drawControl = new L.Control.Draw({
            position: 'bottomleft',
            draw: {
                polygon: false,
                rectangle : false,
                circle : false,
                circlemarker: false,
                marker : false,
                polyline: false,

            },
            edit: false
        });
        map.addControl(drawControl);
        myPolylineDrawHandler =  new L.Draw.Polygon(map, drawControl.options.polygon);
        myPolylineDrawHandler.enable();

        //Make Facet tools
        for (var i = 0; i < 101; i ++) {
            $('.facets').append("<button class='col-md-12' id='pitch-btn' onclick='setPitch(" + i+""+ ")'> <span id='tool-name'>" + i+"/12" + "</span></button>");
        }
        //----------------

        map.on('dragend', function (e) {
            lastPosX = e.target.dragging._lastPos.x;
            lastPosY = e.target.dragging._lastPos.y;
        });

        map.on('zoomend',function(e){ 
            var currZoom = map.getZoom();
            zoomSl = currZoom;
        });

        map.on('click', function(e){
            var coord = e.latlng;
            var lat = coord.lat;
            var lng = coord.lng;
        });

        map.on('draw:drawvertex', function (e) {
            scrollTop = window.scrollY;

            if (la1_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark1_temp.push(marker);
                }
            } else if (la2_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark2_temp.push(marker);
                }
            } else if (la3_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark3_temp.push(marker);
                }
            } else if (la4_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark4_temp.push(marker); 
                }
            } else if (la5_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark5_temp.push(marker); 
                }
            }
        });

        map.on('draw:created', function (e) {
            var type = e.layerType;
            polygon = e.layer;

            drawnItems.addLayer(polygon);
            map.removeLayer(drawnItems);

            drawnItems = null;
            drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);
            if (la1_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark1_temp.push(marker);
                layer1.push(polygon._latlngs);
                polygon.edindex = layer1_polygon.length;
                layer1_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark1_temp.push(area);
                mark1.push(mark1_temp);
                mark1_temp = [];

                var polyline = null;
                var count = layer1.length - 1;
                for (var j = 0; j < layer1[count].length - 1; j ++) {
                    polyline = L.polyline([layer1[count][j], layer1[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer1_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark1[e.target.pgindex][e.target.index]);
                            mark1[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1]);
                            mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark1[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark1[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark1[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (j == layer1[count].length - 2) {
                        polyline = L.polyline([layer1[count][j + 1], layer1[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer1_lines.push(polyline);

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark1[e.target.pgindex][e.target.index + 1]);
                                mark1[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1]);
                                mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer1_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark1[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark1[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark1[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la2_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark2_temp.push(marker);
                layer2.push(polygon._latlngs);
                polygon.edindex = layer2_polygon.length;
                layer2_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark2_temp.push(area);
                mark2.push(mark2_temp);
                mark2_temp = [];

                var polyline = null;
                var count = layer2.length - 1;
                for (var j = 0; j < layer2[count].length - 1; j ++) {
                    polyline = L.polyline([layer2[count][j], layer2[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer2_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark2[e.target.pgindex][e.target.index]);
                            mark2[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1]);
                            mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer2_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark2[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark2[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark2[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer2[count].length - 2) {
                        polyline = L.polyline([layer2[count][j + 1], layer2[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer2_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark2[e.target.pgindex][e.target.index + 1]);
                                mark2[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1]);
                                mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer2_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark2[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark2[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark2[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la3_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark3_temp.push(marker);
                layer3.push(polygon._latlngs); 
                polygon.edindex = layer3_polygon.length; 
                layer3_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark3_temp.push(area);
                mark3.push(mark3_temp);
                mark3_temp = [];

                var polyline = null;
                var count = layer3.length - 1;
                for (var j = 0; j < layer3[count].length - 1; j ++) {
                    polyline = L.polyline([layer3[count][j], layer3[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer3_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark3[e.target.pgindex][e.target.index]);
                            mark3[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1]);
                            mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer3_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark3[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark3[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark3[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer3[count].length - 2) {
                        polyline = L.polyline([layer3[count][j + 1], layer3[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer3_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark3[e.target.pgindex][e.target.index + 1]);
                                mark3[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1]);
                                mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer3_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark3[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark3[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark3[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la4_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark4_temp.push(marker);
                layer4.push(polygon._latlngs); 
                polygon.edindex = layer4_polygon.length;
                layer4_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark4_temp.push(area);
                mark4.push(mark4_temp);
                mark4_temp = [];

                var polyline = null;
                var count = layer4.length - 1;
                for (var j = 0; j < layer4[count].length - 1; j ++) {
                    var polyline = L.polyline([layer4[count][j], layer4[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer4_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark4[e.target.pgindex][e.target.index]);
                            mark4[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1]);
                            mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer4_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark4[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark4[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark4[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer4[count].length - 2) {
                        polyline = L.polyline([layer4[count][j + 1], layer4[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer4_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark4[e.target.pgindex][e.target.index + 1]);
                                mark4[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1]);
                                mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer4_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark4[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark4[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark4[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la5_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark5_temp.push(marker);
                layer5.push(polygon._latlngs);  
                polygon.edindex = layer5_polygon.length;
                layer5_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark5_temp.push(area);
                mark5.push(mark5_temp);
                mark5_temp = [];

                var polyline = null;
                var count = layer5.length - 1;
                for (var j = 0; j < layer5[count].length - 1; j ++) {
                    polyline = L.polyline([layer5[count][j], layer5[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer5_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark5[e.target.pgindex][e.target.index]);
                            mark5[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1]);
                            mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer5_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark5[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark5[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark5[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer5[count].length - 2) {
                        polyline = L.polyline([layer5[count][j + 1], layer5[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer5_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark5[e.target.pgindex][e.target.index + 1]);
                                mark5[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1]);
                                mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer5_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark5[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark5[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark5[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            }
        });

        map.on('draw:editvertex', function (e) {
            var polygon = e.poly;
            if (la1_isClick) {
                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                for (var i = 0; i < mark1[polygon.edindex].length; i ++) {
                    map.removeLayer(mark1[polygon.edindex][i]);
                }

                for (var i = 0; i < resList.length; i ++) {
                    var marker = L.marker(resList[i].line_midLatLng, {
                        icon: L.divIcon({
                            html: resList[i].feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;    

                    mark1[polygon.edindex][i] = marker;
                }  

                var marker = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: mark1[polygon.edindex][mark1[polygon.edindex].length - 1].editing._marker.options.icon.options.html,
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                marker.status = 1;    
                mark1[polygon.edindex][resList.length] = marker;

                map.removeLayer(polygon);

                var polyline = null;
                for (var i = 0; i < layer1[polygon.edindex].length - 1; i ++) {
                    polyline = L.polyline([layer1[polygon.edindex][i], layer1[polygon.edindex][i + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = polygon.edindex;
                    polyline.status = 1;
                    polyline.index = i;
                    polyline.color = '#3388ff';
                    layer1_lines[polygon.edindex * layer1[polygon.edindex].length + i] = polyline;

                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark1[e.target.pgindex][e.target.index]);
                            mark1[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1]);
                            mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark1[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark1[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark1[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (i == layer1[polygon.edindex].length - 2) {
                        polyline = L.polyline([layer1[polygon.edindex][i + 1], layer1[polygon.edindex][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);       
                        polyline.pgindex = polygon.edindex;
                        polyline.status = 1;
                        polyline.index = i;
                        polyline.color = '#3388ff';
                        layer1_lines[polygon.edindex * layer1[polygon.edindex].length + i +1] = polyline;

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark1[e.target.pgindex][e.target.index + 1]);
                                mark1[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1]);
                                mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer1_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark1[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark1[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark1[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }                
                }
            } else if (la2_isClick) {
                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                for (var i = 0; i < mark2[polygon.edindex].length; i ++) {
                    map.removeLayer(mark2[polygon.edindex][i]);
                }

                for (var i = 0; i < resList.length; i ++) {
                    var marker = L.marker(resList[i].line_midLatLng, {
                        icon: L.divIcon({
                            html: resList[i].feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;    

                    mark2[polygon.edindex][i] = marker;
                }  

                var marker = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: mark2[polygon.edindex][mark2[polygon.edindex].length - 1].editing._marker.options.icon.options.html,
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                marker.status = 1;    
                mark2[polygon.edindex][resList.length] = marker;

                map.removeLayer(polygon);

                var polyline = null;
                for (var i = 0; i < layer2[polygon.edindex].length - 1; i ++) {
                    polyline = L.polyline([layer2[polygon.edindex][i], layer2[polygon.edindex][i + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = polygon.edindex;
                    polyline.status = 1;
                    polyline.index = i;
                    polyline.color = '#3388ff';
                    layer2_lines[polygon.edindex * layer2[polygon.edindex].length + i] = polyline;

                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark2[e.target.pgindex][e.target.index]);
                            mark2[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1]);
                            mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer2_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark2[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark2[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark2[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (i == layer2[polygon.edindex].length - 2) {
                        polyline = L.polyline([layer2[polygon.edindex][i + 1], layer2[polygon.edindex][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);       
                        polyline.pgindex = polygon.edindex;
                        polyline.status = 1;
                        polyline.index = i;
                        polyline.color = '#3388ff';
                        layer2_lines[polygon.edindex * layer2[polygon.edindex].length + i +1] = polyline;

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark2[e.target.pgindex][e.target.index + 1]);
                                mark2[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1]);
                                mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer2_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark2[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark2[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark2[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }                
                }
            } else if (la3_isClick) {
                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                for (var i = 0; i < mark3[polygon.edindex].length; i ++) {
                    map.removeLayer(mark3[polygon.edindex][i]);
                }

                for (var i = 0; i < resList.length; i ++) {
                    var marker = L.marker(resList[i].line_midLatLng, {
                        icon: L.divIcon({
                            html: resList[i].feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;    

                    mark3[polygon.edindex][i] = marker;
                }  

                var marker = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: mark3[polygon.edindex][mark3[polygon.edindex].length - 1].editing._marker.options.icon.options.html,
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                marker.status = 1;    
                mark3[polygon.edindex][resList.length] = marker;

                map.removeLayer(polygon);

                var polyline = null;
                for (var i = 0; i < layer3[polygon.edindex].length - 1; i ++) {
                    polyline = L.polyline([layer3[polygon.edindex][i], layer3[polygon.edindex][i + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = polygon.edindex;
                    polyline.status = 1;
                    polyline.index = i;
                    polyline.color = '#3388ff';
                    layer3_lines[polygon.edindex * layer3[polygon.edindex].length + i] = polyline;

                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark3[e.target.pgindex][e.target.index]);
                            mark3[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1]);
                            mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer3_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark3[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark3[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark3[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (i == layer3[polygon.edindex].length - 2) {
                        polyline = L.polyline([layer3[polygon.edindex][i + 1], layer3[polygon.edindex][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);       
                        polyline.pgindex = polygon.edindex;
                        polyline.status = 1;
                        polyline.index = i;
                        polyline.color = '#3388ff';
                        layer3_lines[polygon.edindex * layer3[polygon.edindex].length + i +1] = polyline;

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark3[e.target.pgindex][e.target.index + 1]);
                                mark3[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1]);
                                mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer3_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark3[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark3[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark3[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }                
                }
            } else if (la4_isClick) {
                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                for (var i = 0; i < mark4[polygon.edindex].length; i ++) {
                    map.removeLayer(mark4[polygon.edindex][i]);
                }

                for (var i = 0; i < resList.length; i ++) {
                    var marker = L.marker(resList[i].line_midLatLng, {
                        icon: L.divIcon({
                            html: resList[i].feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;    

                    mark4[polygon.edindex][i] = marker;
                }  

                var marker = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: mark4[polygon.edindex][mark4[polygon.edindex].length - 1].editing._marker.options.icon.options.html,
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                marker.status = 1;    
                mark4[polygon.edindex][resList.length] = marker;

                map.removeLayer(polygon);

                var polyline = null;
                for (var i = 0; i < layer4[polygon.edindex].length - 1; i ++) {
                    polyline = L.polyline([layer4[polygon.edindex][i], layer4[polygon.edindex][i + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = polygon.edindex;
                    polyline.status = 1;
                    polyline.index = i;
                    polyline.color = '#3388ff';
                    layer4_lines[polygon.edindex * layer4[polygon.edindex].length + i] = polyline;

                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark4[e.target.pgindex][e.target.index]);
                            mark4[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1]);
                            mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer4_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark4[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark4[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark4[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (i == layer4[polygon.edindex].length - 2) {
                        polyline = L.polyline([layer4[polygon.edindex][i + 1], layer4[polygon.edindex][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);       
                        polyline.pgindex = polygon.edindex;
                        polyline.status = 1;
                        polyline.index = i;
                        polyline.color = '#3388ff';
                        layer4_lines[polygon.edindex * layer4[polygon.edindex].length + i +1] = polyline;

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark4[e.target.pgindex][e.target.index + 1]);
                                mark4[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1]);
                                mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer4_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark4[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark4[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark4[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }                
                }
            } else if (la5_isClick) {
                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                for (var i = 0; i < mark5[polygon.edindex].length; i ++) {
                    map.removeLayer(mark5[polygon.edindex][i]);
                }

                for (var i = 0; i < resList.length; i ++) {
                    var marker = L.marker(resList[i].line_midLatLng, {
                        icon: L.divIcon({
                            html: resList[i].feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;    

                    mark5[polygon.edindex][i] = marker;
                }  

                var marker = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: mark5[polygon.edindex][mark5[polygon.edindex].length - 1].editing._marker.options.icon.options.html,
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                marker.status = 1;    
                mark5[polygon.edindex][resList.length] = marker;

                map.removeLayer(polygon);

                var polyline = null;
                for (var i = 0; i < layer5[polygon.edindex].length - 1; i ++) {
                    polyline = L.polyline([layer5[polygon.edindex][i], layer5[polygon.edindex][i + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = polygon.edindex;
                    polyline.status = 1;
                    polyline.index = i;
                    polyline.color = '#3388ff';
                    layer5_lines[polygon.edindex * layer5[polygon.edindex].length + i] = polyline;

                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark5[e.target.pgindex][e.target.index]);
                            mark5[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1]);
                            mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer5_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark5[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark5[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark5[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (i == layer5[polygon.edindex].length - 2) {
                        polyline = L.polyline([layer5[polygon.edindex][i + 1], layer5[polygon.edindex][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);       
                        polyline.pgindex = polygon.edindex;
                        polyline.status = 1;
                        polyline.index = i;
                        polyline.color = '#3388ff';
                        layer5_lines[polygon.edindex * layer5[polygon.edindex].length + i +1] = polyline;

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark5[e.target.pgindex][e.target.index + 1]);
                                mark5[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1]);
                                mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer5_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark5[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark5[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark5[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }                
                }
            } 
        });
        //-----------------------Set Draw Button First
        $('#normal_draw').click();
        //-----------------------

        wndHeight = $('#map').height();
        wndWidth = $('#map').width();
        headerHeight = $('.main-header').height();
        menuWidth = $('.main-sidebar').width();

        // firstModal.style.display = "block";
        $('#layer1').removeClass('layer_btn');
        $('#layer1').addClass('btn-primary');
        $('#layer1').click();
        la1_isClick = true;

        var _URL = window.URL || window.webkitURL;
        $('#input_file').change(function(e){
            $('#upload_panel').height(350);

            var file = $(this)[0].files[0];
            img = new Image();
            img.src = _URL.createObjectURL(file);
            img.onload = function() {
                imgwidth = this.width;
                imgheight = this.height;
            };
            
            var reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function () {
                fileContent = reader.result;
                fileName = e.target.files[0].name;
                $('#after_input_img').append('<h5 style="text-align: center;">Preview:</h5>');
                $('#after_input_img').append('<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;"><img style="width: 100%; height: 150px;" id="thelogo" src="' + fileContent + '"></div>');
                $('#after_input_img').append('<h5 style="text-align: center;">' + fileName + '</h5>');
            }
        });
    });

    function rotateright(value) {
        degree += value;
        var v = 'rotate(' + degree + '' + 'deg)';
        $('#map').css({
            'transform': v
        });
    }

    function rotateleft(value) {
        degree += value;
        var v = 'rotate(' + degree + '' + 'deg)';
        $('#map').css({
            'transform': v
        });
    }

    function zoomout() {
        var zoomLevel = map.getZoom();
        zoomLevel = zoomLevel - 1;
        if (zoomLevel < -1)
            return;
        else
            map.setZoom(zoomLevel);
    }   

    function zoomin() {
        var zoomLevel = map.getZoom();
        zoomLevel = zoomLevel + 1;
        if (zoomLevel > 9)
            return;
        else
            map.setZoom(zoomLevel);
    }

    function crosshair() {
        crossHairStatus = !crossHairStatus;
        if (crossHairStatus) {
            $(".leaflet-mouse-marker").css ({
                'cursor': 'none'
            });    

            $(".content-wrapper").css ({
                'cursor': 'none'
            }); 
            $('.panel-default').append('<div id="vertical" style="pointer-events: none;"></div>');  
            $('.panel-default').append('<div id="horizontal" style="pointer-events: none;"></div>');  

            $('#map').on('mousemove', null, [$('#horizontal'), $('#vertical')],function(e){
                e.data[1].css('left', e.pageX);
                e.data[0].css('top', e.pageY);
            });
            $('#map').on('mouseenter', null, [$('#horizontal'), $('#vertical')], function(e){
                e.data[0].show();
                e.data[1].show();
            }).on('mouseleave', null, [$('#horizontal'), $('#vertical')], function(e){
            });
        } else {
            $("#vertical").remove();
            $("#horizontal").remove();

            $(".leaflet-mouse-marker").css ({
                'cursor': 'url(../bower_components/AdminLTE/dist/img/non-cross.cur), auto'
            });    
        }
    }

    function showgrid() {
        showgridStatus = !showgridStatus;
        if (showgridStatus) {
            $('#grid').css({
                'z-index': '1',
                'position': 'absolute',
                'height': '860px',
                'background-size': '60px 30px',
                'background-image': 'linear-gradient(to right, white 2px, transparent 1px), linear-gradient(to bottom, white 2px, transparent 1px)'
            });
        } else {
            $('#grid').css({
                'z-index': '',
                'position': '',
                'height': '',
                'background-size': '',
                'background-image': ''
            });
        }
    }

    function dormer() {
        dormerStatus = !dormerStatus;
    }

    function twostory() {
        twostoryStatus = !twostoryStatus;
    }

    function twolayer() {
        twolayerStatus = !twolayerStatus;
    }

    function lowslope() {
        lowslopeStatus = !lowslopeStatus;
    }

    function changeLabelMarker(label) {
        changeLabelMarkerStatus = !changeLabelMarkerStatus;
        if (labelMarkers.indexOf(label) == -1) {
            labelMarkers.push(label);
        } else {
            labelMarkers.splice(labelMarkers.indexOf(label), 1);
        }
    }

    function deleteEdge() {
        deleteEdgeStatus = !deleteEdgeStatus;
    }

    function changeEdge(color) {
        lineColor = color;
        changeLineStatus = true;                            

    }

    function deleteFacet() {
        removefacetStatus = !removefacetStatus;
    }

    function deletePitch() {
        removepitchStatus = !removepitchStatus;
    }

    function setPitch(value) {
        pitchVal = value;
        setpitchStatus = !setpitchStatus;
    }

    function calculatePolygonArea(poly, pitch) {
        var total = 0;

        var vertices = poly.getLatLngs();
        for (var i = 0, l = vertices.length; i < l; i++) {
          var addX = vertices[i].lat;
          var addY = vertices[i == vertices.length - 1 ? 0 : i + 1].lng;
          var subX = vertices[i == vertices.length - 1 ? 0 : i + 1].lat;
          var subY = vertices[i].lng;

          total += (addX * addY * 0.5);
          total -= (subX * subY * 0.5);
        }

        var area = Math.round((Math.abs(total) * pixelInchRatio1 * pixelInchRatio1)/(12 * 12));
        area = Math.round((Math.sqrt(12*12 + pitch*pitch)/12) * area);

        return area;
    }

    $('#download-pdf').click(function() {
        var totalArea = 0;
        for (var i = 0; i < mark1.length; i ++) {
            for (var j = 0; j < mark1[i].length; j ++) {
                if (j == mark1[i].length - 1) {
                    var area = parseInt(mark1[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark2.length; i ++) {
            for (var j = 0; j < mark2[i].length; j ++) {
                if (j == mark2[i].length - 1) {
                    var area = parseInt(mark2[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark3.length; i ++) {
            for (var j = 0; j < mark3[i].length; j ++) {
                if (j == mark3[i].length - 1) {
                    var area = parseInt(mark3[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark4.length; i ++) {
            for (var j = 0; j < mark4[i].length; j ++) {
                if (j == mark4[i].length - 1) {
                    var area = parseInt(mark4[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark5.length; i ++) {
            for (var j = 0; j < mark5[i].length; j ++) {
                if (j == mark5[i].length - 1) {
                    var area = parseInt(mark5[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        var zero_twel, one_twel, two_twel, three_twel, four_twel, five_twel, six_twel, seven_twel, eight_twel, nine_twel, ten_twel;
        for (var i = 0; i < layer1_polygon.length; i ++) {
            if (layer1_polygon[i].pitch == 0) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);

                zero_twel += area;
            }
        }

        $('#type').val('pdf');
        $('#real-address').val('Address');
        $('#total-area').val(totalArea + '');
        $('#image').val($('img').attr('src'));
        $("#download_form").submit();
    });

    $('#download-csv').click(function() {
        var totalArea = 0;
        for (var i = 0; i < mark1.length; i ++) {
            for (var j = 0; j < mark1[i].length; j ++) {
                if (j == mark1[i].length - 1) {
                    var area = parseInt(mark1[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark2.length; i ++) {
            for (var j = 0; j < mark2[i].length; j ++) {
                if (j == mark2[i].length - 1) {
                    var area = parseInt(mark2[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark3.length; i ++) {
            for (var j = 0; j < mark3[i].length; j ++) {
                if (j == mark3[i].length - 1) {
                    var area = parseInt(mark3[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark4.length; i ++) {
            for (var j = 0; j < mark4[i].length; j ++) {
                if (j == mark4[i].length - 1) {
                    var area = parseInt(mark4[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        for (var i = 0; i < mark5.length; i ++) {
            for (var j = 0; j < mark5[i].length; j ++) {
                if (j == mark5[i].length - 1) {
                    var area = parseInt(mark5[i][j].dragging._marker.options.icon.options.html);
                    totalArea += area;
                }

            }
        }

        var zero_twel = 0, one_twel = 0, two_twel = 0, three_twel = 0, four_twel = 0, five_twel = 0, six_twel = 0, seven_twel = 0, eight_twel = 0, nine_twel = 0, ten_twel = 0;
        for (var i = 0; i < layer1_polygon.length; i ++) {
            if (layer1_polygon[i].pitch == 0) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                zero_twel += area;
            } else if (layer1_polygon[i].pitch == 1) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                one_twel += area;
            } else if (layer1_polygon[i].pitch == 2) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                two_twel += area;
            } else if (layer1_polygon[i].pitch == 3) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                three_twel += area;
            } else if (layer1_polygon[i].pitch == 4) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                four_twel += area;
            } else if (layer1_polygon[i].pitch == 5) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                five_twel += area;
            } else if (layer1_polygon[i].pitch == 6) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                six_twel += area;
            } else if (layer1_polygon[i].pitch == 7) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seven_twel += area;
            } else if (layer1_polygon[i].pitch == 8) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eight_twel += area;
            } else if (layer1_polygon[i].pitch == 9) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                nine_twel += area;
            } else if (layer1_polygon[i].pitch == 9) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            }
        }

        for (var i = 0; i < layer2_polygon.length; i ++) {
            if (layer2_polygon[i].pitch == 0) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                zero_twel += area;
            } else if (layer2_polygon[i].pitch == 1) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                one_twel += area;
            } else if (layer2_polygon[i].pitch == 2) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                two_twel += area;
            } else if (layer2_polygon[i].pitch == 3) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                three_twel += area;
            } else if (layer2_polygon[i].pitch == 4) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                four_twel += area;
            } else if (layer2_polygon[i].pitch == 5) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                five_twel += area;
            } else if (layer2_polygon[i].pitch == 6) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                six_twel += area;
            } else if (layer2_polygon[i].pitch == 7) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seven_twel += area;
            } else if (layer2_polygon[i].pitch == 8) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eight_twel += area;
            } else if (layer2_polygon[i].pitch == 9) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                nine_twel += area;
            } else if (layer2_polygon[i].pitch == 9) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            }
        }

        for (var i = 0; i < layer3_polygon.length; i ++) {
            if (layer3_polygon[i].pitch == 0) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                zero_twel += area;
            } else if (layer3_polygon[i].pitch == 1) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                one_twel += area;
            } else if (layer3_polygon[i].pitch == 2) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                two_twel += area;
            } else if (layer3_polygon[i].pitch == 3) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                three_twel += area;
            } else if (layer3_polygon[i].pitch == 4) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                four_twel += area;
            } else if (layer3_polygon[i].pitch == 5) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                five_twel += area;
            } else if (layer3_polygon[i].pitch == 6) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                six_twel += area;
            } else if (layer3_polygon[i].pitch == 7) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seven_twel += area;
            } else if (layer3_polygon[i].pitch == 8) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eight_twel += area;
            } else if (layer3_polygon[i].pitch == 9) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                nine_twel += area;
            } else if (layer3_polygon[i].pitch == 9) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            }
        }

        for (var i = 0; i < layer4_polygon.length; i ++) {
            if (layer4_polygon[i].pitch == 0) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                zero_twel += area;
            } else if (layer4_polygon[i].pitch == 1) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                one_twel += area;
            } else if (layer4_polygon[i].pitch == 2) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                two_twel += area;
            } else if (layer4_polygon[i].pitch == 3) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                three_twel += area;
            } else if (layer4_polygon[i].pitch == 4) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                four_twel += area;
            } else if (layer4_polygon[i].pitch == 5) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                five_twel += area;
            } else if (layer4_polygon[i].pitch == 6) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                six_twel += area;
            } else if (layer4_polygon[i].pitch == 7) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seven_twel += area;
            } else if (layer4_polygon[i].pitch == 8) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eight_twel += area;
            } else if (layer4_polygon[i].pitch == 9) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                nine_twel += area;
            } else if (layer4_polygon[i].pitch == 9) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            }
        }

        for (var i = 0; i < layer5_polygon.length; i ++) {
            if (layer5_polygon[i].pitch == 0) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                zero_twel += area;
            } else if (layer5_polygon[i].pitch == 1) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                one_twel += area;
            } else if (layer5_polygon[i].pitch == 2) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                two_twel += area;
            } else if (layer5_polygon[i].pitch == 3) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                three_twel += area;
            } else if (layer5_polygon[i].pitch == 4) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                four_twel += area;
            } else if (layer5_polygon[i].pitch == 5) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                five_twel += area;
            } else if (layer5_polygon[i].pitch == 6) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                six_twel += area;
            } else if (layer5_polygon[i].pitch == 7) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seven_twel += area;
            } else if (layer5_polygon[i].pitch == 8) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eight_twel += area;
            } else if (layer5_polygon[i].pitch == 9) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                nine_twel += area;
            } else if (layer5_polygon[i].pitch == 9) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            }
        }

        $('#type').val('csv');
        $('#real-address').val('Address');
        $('#total-area').val(totalArea + '');
        $('#zero_twel').val(zero_twel + '');
        $('#one_twel').val(one_twel + '');
        $('#two_twel').val(two_twel + '');
        $('#three_twel').val(three_twel + '');
        $('#four_twel').val(four_twel + '');
        $('#five_twel').val(five_twel + '');
        $('#six_twel').val(six_twel + '');
        $('#seven_twel').val(seven_twel + '');
        $('#eight_twel').val(eight_twel + '');
        $('#nine_twel').val(nine_twel + '');
        $('#ten_twel').val(ten_twel + '');
        $( "#download_form" ).submit();
    });

    function hideToolbar() {
        $('#right_tool_bar').removeClass("normal");
        $('#right_tool_bar').addClass("grow");

        $('#right').addClass('hidden');
        $('#left').removeClass('hidden');
        $('#left').css({
            'margin-top' : '0px'
        });

        $('span[id*=tool-name]').addClass('hidden');
        $('div[id=name]').addClass('hidden');
        $('#normal_draw').addClass('hide-tool');
        $('#move_anchor').addClass('hide-tool');
    }

    function showToolbar() {
        $('#right_tool_bar').addClass("normal");
        $('#right_tool_bar').removeClass("grow");

        $('#right').removeClass('hidden');
        $('#left').addClass('hidden');
        $('#left').css({
            'margin-top' : '13px'
        });

        $('span[id*=tool-name]').removeClass('hidden');
        $('div[id=name]').removeClass('hidden');
        $('#normal_draw').removeClass('hide-tool');
        $('#move_anchor').removeClass('hide-tool');
    }

    function firstModalClose() {
        firstModal.style.display = "none";

        //-----------------------Header Draw Button Set
        $('#draw-tab').click();
        $('#draw-tab').focus();
        //-----------------------
    }

    function uploadModalClose() {
        uploadModal.style.display = "none";
    }

    function setInchModalClose() {
        myPolylineDrawHandler.disable();

        $('#feet').val("");
        $('#inch').val("");

        setInchModal.style.display = "none";
    }

    function deleteModalClose() {
        deleteModal.style.display = "none";
    }

    $('#draw-tab').click(function() {
        changeLineStatus = false;
        deleteAllEdge();
        drawTabStatus = true;
        edgeTabStatus = false;
        faceTabStatus = false;

        if (la1_isClick) {
            for (var i = 0; i < layer1_lines.length; i ++) {
                if (layer1_lines[i].status == 1) {
                    layer1_lines[i].setStyle({color: layer1_lines[i].color});
                    layer1_lines[i].addTo(map);
                }
            }

            var temp_mark1 = [], temp1 = [];
            for (var j = 0; j < mark1.length; j++) {
                for (var k = 0; k < mark1[j].length; k ++) {
                    if (mark1[j][k].status == 1) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark1.push(marker);
                    } else if (mark1[j][k].status == 0) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark1.push(marker);
                    }
                }
                temp1[j] = temp_mark1;
                temp_mark1 = [];
            }
            mark1 = [];
            mark1 = temp1;

            var temp_label1 = [];
            for (var l = 0; l < layer1_polygon.length; l ++) {
                for (var m = 0; m < layer1_polygon[l].templabelMarkers.length; m ++) {
                    var coords = layer1_polygon[l].templabelMarkers[m]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: layer1_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_label1.push(marker);
                }
                layer1_polygon[l].templabelMarkers = temp_label1;
            }
        } else if (la2_isClick) {
            for (var i = 0; i < layer2_lines.length; i ++) {
                if (layer2_lines[i].status == 1) {
                    layer2_lines[i].setStyle({color: layer2_lines[i].color});
                    layer2_lines[i].addTo(map);
                }
            }

            var temp_mark2 = [], temp2 = [];
            for (var j = 0; j < mark2.length; j++) {
                for (var k = 0; k < mark2[j].length; k ++) {
                    if (mark2[j][k].status == 1) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark2.push(marker);
                    } else if (mark2[j][k].status == 0) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark2.push(marker);
                    }
                }
                temp2[j] = temp_mark2;
                temp_mark2 = [];
            }
            mark2 = [];
            mark2 = temp2;

            var temp_label2 = [];
            for (var l = 0; l < layer2_polygon.length; l ++) {
                for (var m = 0; m < layer2_polygon[l].templabelMarkers.length; m ++) {
                    var coords = layer2_polygon[l].templabelMarkers[m]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: layer2_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_label2.push(marker);
                }
                layer2_polygon[l].templabelMarkers = temp_label2;
            }
        } else if (la3_isClick) {
            for (var i = 0; i < layer3_lines.length; i ++) {
                if (layer3_lines[i].status == 1) {
                    layer3_lines[i].setStyle({color: layer3_lines[i].color});
                    layer3_lines[i].addTo(map);
                }
            }

            var temp_mark3 = [], temp3 = [];
            for (var j = 0; j < mark3.length; j++) {
                for (var k = 0; k < mark3[j].length; k ++) {
                    if (mark3[j][k].status == 1) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark3.push(marker);
                    } else if (mark3[j][k].status == 0) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark3.push(marker);
                    }
                }
                temp3[j] = temp_mark3;
                temp_mark3 = [];
            }
            mark3 = [];
            mark3 = temp3;

            var temp_label3 = [];
            for (var l = 0; l < layer3_polygon.length; l ++) {
                for (var m = 0; m < layer3_polygon[l].templabelMarkers.length; m ++) {
                    var coords = layer3_polygon[l].templabelMarkers[m]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: layer3_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_label3.push(marker);
                }
                layer3_polygon[l].templabelMarkers = temp_label3;
            }
        } else if (la4_isClick) {
            for (var i = 0; i < layer4_lines.length; i ++) {
                if (layer4_lines[i].status == 1) {
                    layer4_lines[i].setStyle({color: layer4_lines[i].color});
                    layer4_lines[i].addTo(map);
                }
            }

            var temp_mark4 = [], temp4 = [];
            for (var j = 0; j < mark4.length; j++) {
                for (var k = 0; k < mark4[j].length; k ++) {
                    if (mark4[j][k].status == 1) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark4.push(marker);
                    } else if (mark4[j][k].status == 0) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark4.push(marker);
                    }
                }
                temp4[j] = temp_mark4;
                temp_mark4 = [];
            }
            mark4 = [];
            mark4 = temp4;

            var temp_label4 = [];
            for (var l = 0; l < layer4_polygon.length; l ++) {
                for (var m = 0; m < layer4_polygon[l].templabelMarkers.length; m ++) {
                    var coords = layer4_polygon[l].templabelMarkers[m]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: layer4_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_label4.push(marker);
                }
                layer4_polygon[l].templabelMarkers = temp_label4;
            }
        } else if (la5_isClick) {
            for (var i = 0; i < layer5_lines.length; i ++) {
                if (layer5_lines[i].status == 1) {
                    layer5_lines[i].setStyle({color: layer5_lines[i].color});
                    layer5_lines[i].addTo(map);
                }
            }

            var temp_mark5 = [], temp5 = [];
            for (var j = 0; j < mark5.length; j++) {
                for (var k = 0; k < mark5[j].length; k ++) {
                    if (mark5[j][k].status == 1) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark5.push(marker);
                    } else if (mark5[j][k].status == 0) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark5.push(marker);
                    }
                }
                temp5[j] = temp_mark5;
                temp_mark5 = [];
            }
            mark5 = [];
            mark5 = temp5;

            var temp_label5 = [];
            for (var l = 0; l < layer5_polygon.length; l ++) {
                for (var m = 0; m < layer5_polygon[l].templabelMarkers.length; m ++) {
                    var coords = layer5_polygon[l].templabelMarkers[m]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: layer5_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_label5.push(marker);
                }
                layer5_polygon[l].templabelMarkers = temp_label5;
            }
        }

        $('.edges').addClass('hidden');
        $('#right_tool_bar').removeClass('hidden');
        $('.facets').addClass('hidden');
    });

    $('#edge-tab').click(function() {
        deleteAllEdge();
        drawTabStatus = false;
        edgeTabStatus = true;
        faceTabStatus = false;

        if (la1_isClick) {
            for (var i = 0; i < layer1_lines.length; i ++) {
                if (layer1_lines[i].status == 1) {
                    layer1_lines[i].setStyle({color: layer1_lines[i].color});
                    layer1_lines[i].addTo(map);
                }
            }

            var temp_mark1 = [], temp1 = [];
            for (var j = 0; j < mark1.length; j++) {
                for (var k = 0; k < mark1[j].length; k ++) {
                    if (mark1[j][k].status == 1) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark1.push(marker);
                    } else if (mark1[j][k].status == 0) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark1.push(marker);
                    }
                }
                temp1[j] = temp_mark1;
                temp_mark1 = [];
            }
            mark1 = [];
            mark1 = temp1;

            var temp_label1 = [];
            for (var l = 0; l < layer1_polygon.length; l ++) {
                if (layer1_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer1_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer1_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer1_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label1.push(marker);
                    }
                    layer1_polygon[l].templabelMarkers = temp_label1;
                }
            }
        } else if (la2_isClick) {
            for (var i = 0; i < layer2_lines.length; i ++) {
                if (layer2_lines[i].status == 1) {
                    layer2_lines[i].setStyle({color: layer2_lines[i].color});
                    layer2_lines[i].addTo(map);
                }
            }

            var temp_mark2 = [], temp2 = [];
            for (var j = 0; j < mark2.length; j++) {
                for (var k = 0; k < mark2[j].length; k ++) {
                    if (mark2[j][k].status == 1) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark2.push(marker);
                    } else if (mark2[j][k].status == 0) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark2.push(marker);
                    }
                }
                temp2[j] = temp_mark2;
                temp_mark2 = [];
            }
            mark2 = [];
            mark2 = temp2;

            var temp_label2 = [];
            for (var l = 0; l < layer2_polygon.length; l ++) {
                if (layer2_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer2_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer2_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer2_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label2.push(marker);
                    }
                    layer2_polygon[l].templabelMarkers = temp_label2;
                }
            }
        } else if (la3_isClick) {
            for (var i = 0; i < layer3_lines.length; i ++) {
                if (layer3_lines[i].status == 1) {
                    layer3_lines[i].setStyle({color: layer3_lines[i].color});
                    layer3_lines[i].addTo(map);
                }
            }

            var temp_mark3 = [], temp3 = [];
            for (var j = 0; j < mark3.length; j++) {
                for (var k = 0; k < mark3[j].length; k ++) {
                    if (mark3[j][k].status == 1) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark3.push(marker);
                    } else if (mark3[j][k].status == 0) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark3.push(marker);
                    }
                }
                temp3[j] = temp_mark3;
                temp_mark3 = [];
            }
            mark3 = [];
            mark3 = temp3;

            var temp_label3 = [];
            for (var l = 0; l < layer3_polygon.length; l ++) {
                if (layer3_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer3_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer3_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer3_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label3.push(marker);
                    }
                    layer3_polygon[l].templabelMarkers = temp_label3;
                }
            }
        } else if (la4_isClick) {
            for (var i = 0; i < layer4_lines.length; i ++) {
                if (layer4_lines[i].status == 1) {
                    layer4_lines[i].setStyle({color: layer4_lines[i].color});
                    layer4_lines[i].addTo(map);
                }
            }

            var temp_mark4 = [], temp4 = [];
            for (var j = 0; j < mark4.length; j++) {
                for (var k = 0; k < mark4[j].length; k ++) {
                    if (mark4[j][k].status == 1) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark4.push(marker);
                    } else if (mark4[j][k].status == 0) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark4.push(marker);
                    }
                }
                temp4[j] = temp_mark4;
                temp_mark4 = [];
            }
            mark4 = [];
            mark4 = temp4;

            var temp_label4 = [];
            for (var l = 0; l < layer4_polygon.length; l ++) {
                if (layer4_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer4_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer4_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer4_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label4.push(marker);
                    }
                    layer4_polygon[l].templabelMarkers = temp_label4;
                }
            }
        } else if (la5_isClick) {
            for (var i = 0; i < layer5_lines.length; i ++) {
                if (layer5_lines[i].status == 1) {
                    layer5_lines[i].setStyle({color: layer5_lines[i].color});
                    layer5_lines[i].addTo(map);
                }
            }

            var temp_mark5 = [], temp5 = [];
            for (var j = 0; j < mark5.length; j++) {
                for (var k = 0; k < mark5[j].length; k ++) {
                    if (mark5[j][k].status == 1) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark5.push(marker);
                    } else if (mark5[j][k].status == 0) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark5.push(marker);
                    }
                }
                temp5[j] = temp_mark5;
                temp_mark5 = [];
            }
            mark5 = [];
            mark5 = temp5;

            var temp_label5 = [];
            for (var l = 0; l < layer5_polygon.length; l ++) {
                if (layer5_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer5_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer5_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer5_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label5.push(marker);
                    }
                    layer5_polygon[l].templabelMarkers = temp_label5;
                }
            }
        }

        $('#right_tool_bar').addClass('hidden');
        $('.edges').removeClass('hidden');
        $('.facets').addClass('hidden');
    });

    $('#facet-tab').click(function() {
        changeLineStatus = false;
        deleteAllEdge();
        drawTabStatus = false;
        edgeTabStatus = false;
        faceTabStatus = true;

        if (la1_isClick) {
            for (var i = 0; i < layer1_polygon.length; i ++) {
                var polygon = layer1_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];

                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.disable();
                polygon.addTo(map);
                polygon.index = i;
                polygon.on('click', function(e) {
                    var coords = e.target.getBounds().getCenter();
                    var lng = coords.lng - offset;
                    var lat = coords.lat;
                    if (removefacetStatus) {
                        e.target.setStyle({fillColor: 'transparent'});
                        e.target.fillColor = 'transparent';
                        e.target.removefacetStatus = true;
                        var tempLatLng = mark1[e.target.index][mark1[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark1[e.target.index][mark1[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: "X",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark1[e.target.index][mark1[e.target.index].length - 1] = marker;
                        removefacetStatus = false;
                    }

                    if (setpitchStatus) {
                        var a = calculatePolygonArea(e.target, pitchVal);
                        if (!e.target.removefacetStatus) {
                            e.target.setStyle({fillColor: 'black'});
                            e.target.fillColor = 'black';
                        }

                        var tempLatLng = mark1[e.target.index][mark1[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark1[e.target.index][mark1[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: a + "sqft",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark1[e.target.index][mark1[e.target.index].length - 1] = marker;

                        e.target.pitch = pitchVal;
                        setpitchStatus = false;
                    }

                    if (removepitchStatus) {
                        if (e.target.options.fillColor == 'black') {
                            e.target.setStyle({fillColor: '#3388ff'});   
                            e.target.fillColor = '#3388ff';
                            removepitchStatus = false;                     
                        }
                    }

                    if (changeLabelMarkerStatus) {
                        if (e.target.labelMarkers.indexOf(settedMark) == -1) {
                            e.target.labelMarkers.push(settedMark);
                        } else {
                            e.target.labelMarkers.splice(e.target.labelMarkers.indexOf(settedMark), 1);
                        }

                        for (var i = 0; i < e.target.templabelMarkers.length; i ++) {
                            map.removeLayer(e.target.templabelMarkers[i]);
                        }                        
                        e.target.templabelMarkers = [];    

                        for (var j = 0; j < e.target.labelMarkers.length; j ++) {
                            var marker = L.marker([lat + (j+1)*30, lng], {
                                icon: L.divIcon({
                                    html: e.target.labelMarkers[j],
                                    className: 'text-below-marker',
                                })
                            }).addTo(map);
                            e.target.templabelMarkers.push(marker);
                        }
                        changeLabelMarkerStatus = false;
                    }
                });
                drawnItems.addLayer(polygon);
            }

            var temp_mark1 = [], temp1 = [];
            for (var j = 0; j < mark1.length; j++) {
                for (var k = 0; k < mark1[j].length; k ++) {
                    if (mark1[j][k].status == 1) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark1.push(marker);
                    } else if (mark1[j][k].status == 0) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark1.push(marker);
                    }
                }
                temp1[j] = temp_mark1;
                temp_mark1 = [];
            }
            mark1 = [];
            mark1 = temp1;

            var temp_label1 = [];
            for (var l = 0; l < layer1_polygon.length; l ++) {
                if (layer1_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer1_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer1_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer1_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label1.push(marker);
                    }
                    layer1_polygon[l].templabelMarkers = temp_label1;
                }
            }
        } else if (la2_isClick) {
            for (var i = 0; i < layer2_polygon.length; i ++) {
                var polygon = layer2_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.disable();
                polygon.addTo(map);
                polygon.index = i;
                polygon.on('click', function(e) {
                    var coords = e.target.getBounds().getCenter();
                    var lng = coords.lng - offset;
                    var lat = coords.lat + 30;
                   if (removefacetStatus) {
                        e.target.setStyle({fillColor: 'transparent'});
                        e.target.fillColor = 'transparent';
                        e.target.removefacetStatus = true;
                        var tempLatLng = mark2[e.target.index][mark2[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark2[e.target.index][mark2[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: "X",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark2[e.target.index][mark2[e.target.index].length - 1] = marker;
                        removefacetStatus = false;
                    }

                    if (setpitchStatus) {
                        var a = calculatePolygonArea(e.target, pitchVal);
                        if (!e.target.removefacetStatus) {
                            e.target.setStyle({fillColor: 'black'});
                            e.target.fillColor = 'black';
                        }

                        var tempLatLng = mark2[e.target.index][mark2[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark2[e.target.index][mark2[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: a + "sqft",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark2[e.target.index][mark2[e.target.index].length - 1] = marker;

                        e.target.pitch = pitchVal;
                        setpitchStatus = false;
                    }

                    if (removepitchStatus) {
                        if (e.target.options.fillColor == 'black') {
                            e.target.setStyle({fillColor: '#3388ff'});   
                            e.target.fillColor = '#3388ff';
                            removepitchStatus = false;                     
                        }
                    }

                    if (changeLabelMarkerStatus) {
                        if (e.target.labelMarkers.indexOf(settedMark) == -1) {
                            e.target.labelMarkers.push(settedMark);
                        } else {
                            e.target.labelMarkers.splice(e.target.labelMarkers.indexOf(settedMark), 1);
                        }

                        for (var i = 0; i < e.target.templabelMarkers.length; i ++) {
                            map.removeLayer(e.target.templabelMarkers[i]);
                        }                        
                        e.target.templabelMarkers = [];    

                        for (var j = 0; j < e.target.labelMarkers.length; j ++) {
                            var marker = L.marker([lat + (j+1)*30, lng], {
                                icon: L.divIcon({
                                    html: e.target.labelMarkers[j],
                                    className: 'text-below-marker',
                                })
                            }).addTo(map);
                            e.target.templabelMarkers.push(marker);
                        }
                        changeLabelMarkerStatus = false;
                    }
                });
                drawnItems.addLayer(polygon);
            }
            var temp_mark2 = [], temp2 = [];
            for (var j = 0; j < mark2.length; j++) {
                for (var k = 0; k < mark2[j].length; k ++) {
                    if (mark2[j][k].status == 1) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark2.push(marker);
                    } else if (mark2[j][k].status == 0) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark2.push(marker);
                    }
                }
                temp2[j] = temp_mark2;
                temp_mark2 = [];
            }
            mark2 = [];
            mark2 = temp2;

            var temp_label2 = [];
            for (var l = 0; l < layer2_polygon.length; l ++) {
                if (layer2_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer2_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer2_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer2_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label2.push(marker);
                    }
                    layer2_polygon[l].templabelMarkers = temp_label2;
                }
            }
        } else if (la3_isClick) {
            for (var i = 0; i < layer3_polygon.length; i ++) {
                var polygon = layer3_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.disable();
                polygon.addTo(map);
                polygon.index = i;
                polygon.on('click', function(e) {
                    var coords = e.target.getBounds().getCenter();
                    var lng = coords.lng - offset;
                    var lat = coords.lat + 30;
                    if (removefacetStatus) {
                        e.target.setStyle({fillColor: 'transparent'});
                        e.target.removefacetStatus = true;
                        var tempLatLng = mark3[e.target.index][mark3[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark3[e.target.index][mark3[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: "X",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark3[e.target.index][mark3[e.target.index].length - 1] = marker;
                        removefacetStatus = false;
                    }

                    if (setpitchStatus) {
                        var a = calculatePolygonArea(e.target, pitchVal);
                        if (!e.target.removefacetStatus) {
                            e.target.setStyle({fillColor: 'black'});
                            e.target.fillColor = 'black';
                        }

                        var tempLatLng = mark3[e.target.index][mark3[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark3[e.target.index][mark3[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: a + "sqft",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark3[e.target.index][mark3[e.target.index].length - 1] = marker;

                        e.target.pitch = pitchVal;
                        setpitchStatus = false;
                    }

                    if (removepitchStatus) {
                        if (e.target.options.fillColor == 'black') {
                            e.target.setStyle({fillColor: '#3388ff'});   
                            e.target.fillColor = '#3388ff';
                            removepitchStatus = false;                     
                        }
                    }

                    if (changeLabelMarkerStatus) {
                        if (e.target.labelMarkers.indexOf(settedMark) == -1) {
                            e.target.labelMarkers.push(settedMark);
                        } else {
                            e.target.labelMarkers.splice(e.target.labelMarkers.indexOf(settedMark), 1);
                        }

                        for (var i = 0; i < e.target.templabelMarkers.length; i ++) {
                            map.removeLayer(e.target.templabelMarkers[i]);
                        }                        
                        e.target.templabelMarkers = [];    

                        for (var j = 0; j < e.target.labelMarkers.length; j ++) {
                            var marker = L.marker([lat + (j+1)*30, lng], {
                                icon: L.divIcon({
                                    html: e.target.labelMarkers[j],
                                    className: 'text-below-marker',
                                })
                            }).addTo(map);
                            e.target.templabelMarkers.push(marker);
                        }
                        changeLabelMarkerStatus = false;
                    }
                });
                drawnItems.addLayer(polygon);
            }

            var temp_mark3 = [], temp3 = [];
            for (var j = 0; j < mark3.length; j++) {
                for (var k = 0; k < mark3[j].length; k ++) {
                    if (mark3[j][k].status == 1) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark3.push(marker);
                    } else if (mark3[j][k].status == 0) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark3.push(marker);
                    }
                }
                temp3[j] = temp_mark3;
                temp_mark3 = [];
            }
            mark3 = [];
            mark3 = temp3;

            var temp_label3 = [];
            for (var l = 0; l < layer3_polygon.length; l ++) {
                if (layer3_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer3_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer3_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer3_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label3.push(marker);
                    }
                    layer3_polygon[l].templabelMarkers = temp_label3;
                }
            }
        } else if (la4_isClick) {
            for (var i = 0; i < layer4_polygon.length; i ++) {
                var polygon = layer4_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.disable();
                polygon.addTo(map);
                polygon.index = i;
                polygon.on('click', function(e) {
                    var coords = e.target.getBounds().getCenter();
                    var lng = coords.lng - offset;
                    var lat = coords.lat + 30;
                    if (removefacetStatus) {
                        e.target.setStyle({fillColor: 'transparent'});
                        e.target.removefacetStatus = true;
                        var tempLatLng = mark4[e.target.index][mark4[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark4[e.target.index][mark4[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: "X",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark4[e.target.index][mark4[e.target.index].length - 1] = marker;
                        removefacetStatus = false;
                    }

                    if (setpitchStatus) {
                        var a = calculatePolygonArea(e.target, pitchVal);
                        if (!e.target.removefacetStatus) {
                            e.target.setStyle({fillColor: 'black'});
                            e.target.fillColor = 'black';
                        }

                        var tempLatLng = mark4[e.target.index][mark4[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark4[e.target.index][mark4[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: a + "sqft",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark4[e.target.index][mark4[e.target.index].length - 1] = marker;

                        e.target.pitch = pitchVal;
                        setpitchStatus = false;
                    }

                    if (removepitchStatus) {
                        if (e.target.options.fillColor == 'black') {
                            e.target.setStyle({fillColor: '#3388ff'});   
                            e.target.fillColor = '#3388ff';
                            removepitchStatus = false;                     
                        }
                    }

                    if (changeLabelMarkerStatus) {
                        if (e.target.labelMarkers.indexOf(settedMark) == -1) {
                            e.target.labelMarkers.push(settedMark);
                        } else {
                            e.target.labelMarkers.splice(e.target.labelMarkers.indexOf(settedMark), 1);
                        }

                        for (var i = 0; i < e.target.templabelMarkers.length; i ++) {
                            map.removeLayer(e.target.templabelMarkers[i]);
                        }                        
                        e.target.templabelMarkers = [];    

                        for (var j = 0; j < e.target.labelMarkers.length; j ++) {
                            var marker = L.marker([lat + (j+1)*30, lng], {
                                icon: L.divIcon({
                                    html: e.target.labelMarkers[j],
                                    className: 'text-below-marker',
                                })
                            }).addTo(map);
                            e.target.templabelMarkers.push(marker);
                        }
                        changeLabelMarkerStatus = false;
                    }
                });  
                drawnItems.addLayer(polygon);
            }

            var temp_mark4 = [], temp4 = [];
            for (var j = 0; j < mark4.length; j++) {
                for (var k = 0; k < mark4[j].length; k ++) {
                    if (mark4[j][k].status == 1) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark4.push(marker);
                    } else if (mark4[j][k].status == 0) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark4.push(marker);
                    }
                }
                temp4[j] = temp_mark4;
                temp_mark4 = [];
            }
            mark4 = [];
            mark4 = temp4;

            var temp_label4 = [];
            for (var l = 0; l < layer4_polygon.length; l ++) {
                if (layer4_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer4_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer4_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer4_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label4.push(marker);
                    }
                    layer4_polygon[l].templabelMarkers = temp_label4;
                }
            }
        } else if (la5_isClick) {
            for (var i = 0; i < layer5_polygon.length; i ++) {
                var polygon = layer5_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.disable();
                polygon.addTo(map);
                polygon.index = i;
                polygon.on('click', function(e) {
                    var coords = e.target.getBounds().getCenter();
                    var lng = coords.lng - offset;
                    var lat = coords.lat + 30;
                    if (removefacetStatus) {
                        e.target.setStyle({fillColor: 'transparent'});
                        e.target.removefacetStatus = true;
                        var tempLatLng = mark5[e.target.index][mark5[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark5[e.target.index][mark5[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: "X",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark5[e.target.index][mark5[e.target.index].length - 1] = marker;
                        removefacetStatus = false;
                    }

                    if (setpitchStatus) {
                        var a = calculatePolygonArea(e.target, pitchVal);
                        if (!e.target.removefacetStatus) {
                            e.target.setStyle({fillColor: 'black'});
                            e.target.fillColor = 'black';
                        }

                        var tempLatLng = mark5[e.target.index][mark5[e.target.index].length - 1].getLatLng();
                        map.removeLayer(mark5[e.target.index][mark5[e.target.index].length - 1]);
                        var marker = L.marker(tempLatLng, {
                            icon: L.divIcon({
                                html: a + "sqft",
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        mark5[e.target.index][mark5[e.target.index].length - 1] = marker;

                        e.target.pitch = pitchVal;
                        setpitchStatus = false;
                    }

                    if (removepitchStatus) {
                        if (e.target.options.fillColor == 'black') {
                            e.target.setStyle({fillColor: '#3388ff'});   
                            e.target.fillColor = '#3388ff';
                            removepitchStatus = false;                     
                        }
                    }

                    if (changeLabelMarkerStatus) {
                        if (e.target.labelMarkers.indexOf(settedMark) == -1) {
                            e.target.labelMarkers.push(settedMark);
                        } else {
                            e.target.labelMarkers.splice(e.target.labelMarkers.indexOf(settedMark), 1);
                        }

                        for (var i = 0; i < e.target.templabelMarkers.length; i ++) {
                            map.removeLayer(e.target.templabelMarkers[i]);
                        }                        
                        e.target.templabelMarkers = [];    

                        for (var j = 0; j < e.target.labelMarkers.length; j ++) {
                            var marker = L.marker([lat + (j+1)*30, lng], {
                                icon: L.divIcon({
                                    html: e.target.labelMarkers[j],
                                    className: 'text-below-marker',
                                })
                            }).addTo(map);
                            e.target.templabelMarkers.push(marker);
                        }
                        changeLabelMarkerStatus = false;
                    }
                });
                drawnItems.addLayer(polygon);
            }

            var temp_mark5 = [], temp5 = [];
            for (var j = 0; j < mark5.length; j++) {
                for (var k = 0; k < mark5[j].length; k ++) {
                    if (mark5[j][k].status == 1) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark5.push(marker);
                    } else if (mark5[j][k].status == 0) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark5.push(marker);
                    }
                }
                temp5[j] = temp_mark5;
                temp_mark5 = [];
            }
            mark5 = [];
            mark5 = temp5;

            var temp_label5 = [];
            for (var l = 0; l < layer5_polygon.length; l ++) {
                if (layer5_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer5_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer5_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer5_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label5.push(marker);
                    }
                    layer5_polygon[l].templabelMarkers = temp_label5;
                }
            }
        }

        $('.facets').removeClass('hidden');
        $('.edges').addClass('hidden');
        $('#right_tool_bar').addClass('hidden');
    });

    $('#plus').click(function() {
        if (btn_index == 4) {
            $('#plus').remove();
        }
        $('#layer' + btn_index).before('<button id = "layer' + (btn_index+1) + '" class="btn layer_btn" style="width: 100%" onclick="layer' + (btn_index+1) + '_click()">' + (btn_index+1) + '</button>');
        btn_index++;
    });

    $('#up').click(function() {
        if (btn_index <= active_index)
            return;

        if (active_index < 5) {
            $('#layer' + active_index + "").removeClass('btn-primary');
            $('#layer' + active_index + "").addClass('layer_btn');

            $('#layer' + (active_index+1) + "").removeClass('layer_btn');
            $('#layer' + (active_index+1) + "").addClass('btn-primary');

            if (active_index == 1)
                layer2_click();
            else if (active_index == 2)
                layer3_click();
            else if (active_index == 3)
                layer4_click();
            else if (active_index == 4)
                layer5_click();

            active_index ++;
        }
    });

    $('#pitch_btn').click(function() {
        $('#pitch_form').submit();
    });

    $('#google_btn').click(function() {
        window.location.href = 'https://www.google.com/maps/@?api=1&map_action=map&zoom=20&basemap=satellite&center={{$lat}},{{$lng}}';
    });

    $('#normal_draw').click(function() {
        myPolylineDrawHandler.enable();
        if (crossHairStatus) {
            $(".leaflet-mouse-marker").css ({
                'cursor': 'none'
            });    
            
            $(".content-wrapper").css ({
                'cursor': 'none'
            }); 
        }
    });

    $('#move_anchor').click(function() {
        deleteAllEdge();
        if (la1_isClick) {
            for (var i = 0; i < layer1_polygon.length; i ++) {
                var polygon = layer1_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];

                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.enable();
                polygon.addTo(map);
                polygon.index = i;
                drawnItems.addLayer(polygon);
            }

            var temp_mark1 = [], temp1 = [];
            for (var j = 0; j < mark1.length; j++) {
                for (var k = 0; k < mark1[j].length; k ++) {
                    if (mark1[j][k].status == 1) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark1.push(marker);
                    } else if (mark1[j][k].status == 0) {
                        var coords = mark1[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark1[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark1.push(marker);
                    }
                }
                temp1[j] = temp_mark1;
                temp_mark1 = [];
            }
            mark1 = [];
            mark1 = temp1;

            var temp_label1 = [];
            for (var l = 0; l < layer1_polygon.length; l ++) {
                if (layer1_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer1_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer1_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer1_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label1.push(marker);
                    }
                    layer1_polygon[l].templabelMarkers = temp_label1;
                }
            }
        } else if (la2_isClick) {
            for (var i = 0; i < layer2_polygon.length; i ++) {
                var polygon = layer2_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];

                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.enable();
                polygon.addTo(map);
                polygon.index = i;
                drawnItems.addLayer(polygon);
            }
            var temp_mark2 = [], temp2 = [];
            for (var j = 0; j < mark2.length; j++) {
                for (var k = 0; k < mark2[j].length; k ++) {
                    if (mark2[j][k].status == 1) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark2.push(marker);
                    } else if (mark2[j][k].status == 0) {
                        var coords = mark2[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark2[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark2.push(marker);
                    }
                }
                temp2[j] = temp_mark2;
                temp_mark2 = [];
            }
            mark2 = [];
            mark2 = temp2;

            var temp_label2 = [];
            for (var l = 0; l < layer2_polygon.length; l ++) {
                if (layer2_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer2_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer2_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer2_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label2.push(marker);
                    }
                    layer2_polygon[l].templabelMarkers = temp_label2;
                }
            }
        } else if (la3_isClick) {
            for (var i = 0; i < layer3_polygon.length; i ++) {
                var polygon = layer3_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.enable();
                polygon.addTo(map);
                polygon.index = i;
                drawnItems.addLayer(polygon);
            }

            var temp_mark3 = [], temp3 = [];
            for (var j = 0; j < mark3.length; j++) {
                for (var k = 0; k < mark3[j].length; k ++) {
                    if (mark3[j][k].status == 1) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark3.push(marker);
                    } else if (mark3[j][k].status == 0) {
                        var coords = mark3[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark3[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark3.push(marker);
                    }
                }
                temp3[j] = temp_mark3;
                temp_mark3 = [];
            }
            mark3 = [];
            mark3 = temp3;

            var temp_label3 = [];
            for (var l = 0; l < layer3_polygon.length; l ++) {
                if (layer3_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer3_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer3_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer3_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label3.push(marker);
                    }
                    layer3_polygon[l].templabelMarkers = temp_label3;
                }
            }
        } else if (la4_isClick) {
            for (var i = 0; i < layer4_polygon.length; i ++) {
                var polygon = layer4_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.enable();
                polygon.addTo(map);
                polygon.index = i;
                drawnItems.addLayer(polygon);
            }

            var temp_mark4 = [], temp4 = [];
            for (var j = 0; j < mark4.length; j++) {
                for (var k = 0; k < mark4[j].length; k ++) {
                    if (mark4[j][k].status == 1) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark4.push(marker);
                    } else if (mark4[j][k].status == 0) {
                        var coords = mark4[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark4[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark4.push(marker);
                    }
                }
                temp4[j] = temp_mark4;
                temp_mark4 = [];
            }
            mark4 = [];
            mark4 = temp4;

            var temp_label4 = [];
            for (var l = 0; l < layer4_polygon.length; l ++) {
                if (layer4_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer4_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer4_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer4_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label4.push(marker);
                    }
                    layer4_polygon[l].templabelMarkers = temp_label4;
                }
            }
        } else if (la5_isClick) {
            for (var i = 0; i < layer5_polygon.length; i ++) {
                var polygon = layer5_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];
                polygon.setStyle({fillColor: polygon.fillColor});
                polygon.editing.enable();
                polygon.addTo(map);
                polygon.index = i;
                drawnItems.addLayer(polygon);
            }

            var temp_mark5 = [], temp5 = [];
            for (var j = 0; j < mark5.length; j++) {
                for (var k = 0; k < mark5[j].length; k ++) {
                    if (mark5[j][k].status == 1) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                        temp_mark5.push(marker);
                    } else if (mark5[j][k].status == 0) {
                        var coords = mark5[j][k]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: mark5[j][k].options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 0;
                        temp_mark5.push(marker);
                    }
                }
                temp5[j] = temp_mark5;
                temp_mark5 = [];
            }
            mark5 = [];
            mark5 = temp5;

            var temp_label5 = [];
            for (var l = 0; l < layer5_polygon.length; l ++) {
                if (layer5_polygon[l].templabelMarkers != undefined) {
                    for (var m = 0; m < layer5_polygon[l].templabelMarkers.length; m ++) {
                        var coords = layer5_polygon[l].templabelMarkers[m]._latlng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: layer5_polygon[l].templabelMarkers[m].dragging._marker.options.icon.options.html,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        temp_label5.push(marker);
                    }
                    layer5_polygon[l].templabelMarkers = temp_label5;
                }
            }
        }
    });

    $('#upload_img').click(function() {
        if (firstModal.style.display == "block" || setInchModal.style.display == "block" || deleteModal.style.display == "block") {
            alert("Close All Before Window");
            return false;
        } else {
            uploadModal.style.display = "block";
        }
    });

    $('#reset_scale').click(function() {
        if (firstModal.style.display == "block" || uploadModal.style.display == "block" || setInchModal.style.display == "block" || deleteModal.style.display == "block") {
            alert("Close All Before Window");
            return false;
        } else {
            resetClicked = true;
            firstModal.style.display = "block";
        }
    })

    function deleteAllEdges() {
        if (firstModal.style.display == "block" || setInchModal.style.display == "block" || uploadModal.style.display == "block") {
            alert("Close All Before Window");
            return false;
        } else {
            deleteModal.style.display = "block";
        }
    };

    function setInch() {
        feet = $("#feet").val();
        inch = $("#inch").val();

        total_inch = Number(feet) * 12 + Number(inch);
        pixelInchRatio = total_inch / firstLength;
        pixelInchRatio1 = total_inch / firstLength;
        
        inchSetted = true;

        $('#feet').val("");
        $('#inch').val("");

        myPolylineDrawHandler.disable();
        setInchModal.style.display = "none";
    }

    function deleteAllEdge() {
        if (drawnItems == null) {
            alert("There isn't any edges on the map.");
            return false;
        }

        if (drawnItems != null) {
            map.removeLayer(drawnItems);
            drawnItems = null;
        } else {
            return false;
        }

        for (var i = 0; i < layer1_lines.length; i ++) {
            map.removeLayer(layer1_lines[i]);
        }

        for (var j = 0; j < layer2_lines.length; j ++) {
            map.removeLayer(layer2_lines[j]);
        }

        for (var k = 0; k < layer3_lines.length; k ++) {
            map.removeLayer(layer3_lines[k]);
        }

        for (var m = 0; m < layer4_lines.length; m ++) {
            map.removeLayer(layer4_lines[m]);
        }

        for (var n = 0; n < layer5_lines.length; n ++) {
            map.removeLayer(layer5_lines[n]);
        }

        if (la1_isClick && mark1.length > 0) {
            for (var i = 0; i < mark1.length; i ++) {
                for (var j = 0; j < mark1[i].length; j ++) {
                    map.removeLayer(mark1[i][j]);
                }
            }

            for (var k = 0; k < layer1_polygon.length; k ++) {
                if (layer1_polygon[k].templabelMarkers != undefined) {
                    for (var l = 0; l < layer1_polygon[k].templabelMarkers.length; l ++) {
                        map.removeLayer(layer1_polygon[k].templabelMarkers[l]);
                    }
                }
            }
        } 

        if (la2_isClick && mark2.length > 0) {
            for (var i = 0; i < mark2.length; i ++) {
                for (var j = 0; j < mark2[i].length; j ++) {
                    map.removeLayer(mark2[i][j]);
                }
            }

            for (var k = 0; k < layer2_polygon.length; k ++) {
                if (layer2_polygon[k].templabelMarkers != undefined) {
                    for (var l = 0; l < layer2_polygon[k].templabelMarkers.length; l ++) {
                        map.removeLayer(layer2_polygon[k].templabelMarkers[l]);
                    }
                }
            }
        } 

        if (la3_isClick && mark3.length > 0) {
            for (var i = 0; i < mark3.length; i ++) {
                for (var j = 0; j < mark3[i].length; j ++) {
                    map.removeLayer(mark3[i][j]);
                }
            }

            for (var k = 0; k < layer3_polygon.length; k ++) {
                if (layer3_polygon[k].templabelMarkers != undefined) {
                    for (var l = 0; l < layer3_polygon[k].templabelMarkers.length; l ++) {
                        map.removeLayer(layer3_polygon[k].templabelMarkers[l]);
                    }
                }
            }
        } 

        if (la4_isClick && mark4.length > 0) {
            for (var i = 0; i < mark4.length; i ++) {
                for (var j = 0; j < mark4[i].length; j ++) {
                    map.removeLayer(mark4[i][j]);
                }
            }

            for (var k = 0; k < layer4_polygon.length; k ++) {
                if (layer4_polygon[k].templabelMarkers != undefined) {
                    for (var l = 0; l < layer4_polygon[k].templabelMarkers.length; l ++) {
                        map.removeLayer(layer4_polygon[k].templabelMarkers[l]);
                    }
                }
            }
        } 

        if (la5_isClick && mark5.length > 0) {
            for (var i = 0; i < mark5.length; i ++) {
                for (var j = 0; j < mark5[i].length; j ++) {
                    map.removeLayer(mark5[i][j]);
                }
            }

            for (var k = 0; k < layer5_polygon.length; k ++) {
                if (layer5_polygon[k].templabelMarkers != undefined) {
                    for (var l = 0; l < layer5_polygon[k].templabelMarkers.length; l ++) {
                        map.removeLayer(layer5_polygon[k].templabelMarkers[l]);
                    }
                }
            }
        }

        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        deleteModal.style.display = "none";
    }

    function resetData() {
        if (drawnItems == null) {
            alert("There isn't any edges on the map.");
            return false;
        }

        if (drawnItems != null) {
            map.removeLayer(drawnItems);
            drawnItems = null;
        } else {
            return false;
        }

        layer1 = [], layer2 = [], layer3 = [], layer4 = [], layer5 = [];
        mark1 = [], mark2 = [], mark3 = [], mark4 = [], mark5 = [];
        layer1_lines = [], layer2_lines = [], layer3_lines = [], layer4_lines = [], layer5_lines = [];
    }

    function fileBrowse() {
        $("#input_file").click();
    }

    function fileBrowse() {
        $("#input_file").click();
    }

    function layer1_click() {
        deleteAllEdge();
        la1_isClick = true;
        la2_isClick = false;
        la3_isClick = false;
        la4_isClick = false;
        la5_isClick = false;

        if (drawTabStatus) {
            $("#draw-tab").click();
            $("#draw-tab").focus();
        } else if (edgeTabStatus) {
            $("#edge-tab").click();
            $("#edge-tab").focus();
        } else if (faceTabStatus) {
            $("#facet-tab").click();
            $("#facet-tab").focus();
        }
    }

    function layer2_click() {
        deleteAllEdge();
        la1_isClick = false;
        la2_isClick = true;
        la3_isClick = false;
        la4_isClick = false;
        la5_isClick = false;  

        if (drawTabStatus) {
            $("#draw-tab").click();
            $("#draw-tab").focus();
        } else if (edgeTabStatus) {
            $("#edge-tab").click();
            $("#edge-tab").focus();
        } else if (faceTabStatus) {
            $("#facet-tab").click();
            $("#facet-tab").focus();
        }
    }

    function layer3_click() {
        deleteAllEdge();
        la1_isClick = false;
        la2_isClick = false;
        la3_isClick = true;
        la4_isClick = false;
        la5_isClick = false; 

        if (drawTabStatus) {
            $("#draw-tab").click();
            $("#draw-tab").focus();
        } else if (edgeTabStatus) {
            $("#edge-tab").click();
            $("#edge-tab").focus();
        } else if (faceTabStatus) {
            $("#facet-tab").click();
            $("#facet-tab").focus();
        }
    }

    function layer4_click() {
        deleteAllEdge();
        la1_isClick = false;
        la2_isClick = false;
        la3_isClick = false;
        la4_isClick = true;
        la5_isClick = false;

        if (drawTabStatus) {
            $("#draw-tab").click();
            $("#draw-tab").focus();
        } else if (edgeTabStatus) {
            $("#edge-tab").click();
            $("#edge-tab").focus();
        } else if (faceTabStatus) {
            $("#facet-tab").click();
            $("#facet-tab").focus();
        }
    }

    function layer5_click() {
        deleteAllEdge();
        la1_isClick = false;
        la2_isClick = false;
        la3_isClick = false;
        la4_isClick = false;
        la5_isClick = true;

        if (drawTabStatus) {
            $("#draw-tab").click();
            $("#draw-tab").focus();
        } else if (edgeTabStatus) {
            $("#edge-tab").click();
            $("#edge-tab").focus();
        } else if (faceTabStatus) {
            $("#facet-tab").click();
            $("#facet-tab").focus();
        }
    }

    function allLayerClick() {
        la1_isClick = true;
        la2_isClick = true;
        la3_isClick = true;
        la4_isClick = true;
        la5_isClick = true;

        deleteAllEdge();

        $('#layer1').addClass('layer_btn');
        $('#layer1').removeClass('btn-primary');
        $('#layer2').addClass('layer_btn');
        $('#layer2').removeClass('btn-primary');
        $('#layer3').addClass('layer_btn');
        $('#layer3').removeClass('btn-primary');
        $('#layer4').addClass('layer_btn');
        $('#layer4').removeClass('btn-primary');
        $('#layer5').addClass('layer_btn');
        $('#layer5').removeClass('btn-primary');

        ////layer1
        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].status == 1) {
                layer1_lines[i].setStyle({color: layer1_lines[i].color});
                layer1_lines[i].addTo(map);
            }
        }
        var temp_mark1 = [];
        for (var j = 0; j < mark1.length; j++) {
            for (var k = 0; k < mark1[j].length; k ++) {
                if (mark1[j][k].status == 1) {
                    var coords = mark1[j][k]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: mark1[j][k].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_mark1.push(marker);
                }
            }
        }
        if (temp_mark1.length > 0)
            mark1.push(temp_mark1);

        //////layer2
        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].status == 1) {
                layer2_lines[i].setStyle({color: layer2_lines[i].color});
                layer2_lines[i].addTo(map);
            }
        }
        var temp_mark2 = [];
        for (var j = 0; j < mark2.length; j++) {
            for (var k = 0; k < mark2[j].length; k ++) {
                if (mark2[j][k].status == 1) {
                    var coords = mark2[j][k]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: mark2[j][k].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_mark2.push(marker);
                }
            }
        }
        if (temp_mark2.length > 0)
            mark2.push(temp_mark2);

        //////layer3
        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].status == 1) {
                layer3_lines[i].setStyle({color: layer3_lines[i].color});
                layer3_lines[i].addTo(map);
            }
        }
        var temp_mark3 = [];
        for (var j = 0; j < mark3.length; j++) {
            for (var k = 0; k < mark3[j].length; k ++) {
                if (mark3[j][k].status == 1) {
                    var coords = mark3[j][k]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: mark3[j][k].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_mark3.push(marker);
                }
            }
        }
        if (temp_mark3.length > 0)
            mark3.push(temp_mark3);

        //////layer4
        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].status == 1) {
                layer4_lines[i].setStyle({color: layer4_lines[i].color});
                layer4_lines[i].addTo(map);
            }
        }
        var temp_mark4 = [];
        for (var j = 0; j < mark4.length; j++) {
            for (var k = 0; k < mark4[j].length; k ++) {
                if (mark4[j][k].status == 1) {
                    var coords = mark4[j][k]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: mark4[j][k].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_mark4.push(marker);
                }
            }
        }
        if (temp_mark4.length > 0)
            mark4.push(temp_mark4);

        //////layer5
        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].status == 1) {
                layer5_lines[i].setStyle({color: layer5_lines[i].color});
                layer5_lines[i].addTo(map);
            }
        }
        var temp_mark5 = [];
        for (var j = 0; j < mark5.length; j++) {
            for (var k = 0; k < mark5[j].length; k ++) {
                if (mark5[j][k].status == 1) {
                    var coords = mark5[j][k]._latlng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: mark5[j][k].dragging._marker.options.icon.options.html,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    temp_mark5.push(marker);
                }
            }
        }
        if (temp_mark5.length > 0)
            mark5.push(temp_mark5);
    }

    function drawLine() {
        $('#normal_draw').click();
        $('#normal_draw').focus();

        firstModal.style.display = "none";
    }

    function showImage() {
        deleteAllEdge();
        resetData();
        //----------------Proto
        inchSetted = false;
        pixelInchRatio = 0.0;
        pixelInchRatio1 = 0.0;
        //---------------------
        map.remove();
        map = null;

        map = L.map('map', { 
            crs: L.CRS.Simple,
            maxZoom: 9,
            minZoom: -1
        });
        map.doubleClickZoom.disable();
        var bounds = [[0, 0], [1300, 1300]];
        if (fileName == '')
            fileName = "map1.jpg";

        var filePath = '{{ asset("/bower_components/AdminLTE/dist/img") }}';
        filePath += '/' + fileName;
        var image = L.imageOverlay(filePath, bounds).addTo(map);
        map.fitBounds(bounds);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            position: 'bottomleft',
            draw: {
                polygon : false,
                rectangle : false,
                circle : false,
                circlemarker: false,
                marker : false,
                polyline: false,
            },
            edit : false
        });
        map.addControl(drawControl);

        myPolylineDrawHandler =  new L.Draw.Polygon(map, drawControl.options.polygon);
        myPolylineDrawHandler.enable();

        map.on('dragend', function (e) {
            lastPosX = e.target.dragging._lastPos.x;
            lastPosY = e.target.dragging._lastPos.y;
        });

        map.on('zoomend',function(e){
            zoomScale =  map.getZoom();
        });

        map.on('draw:drawvertex', function (e) {
            scrollTop = window.scrollY;
            if (la1_isClick) {
                if (vertextCnt > 0 && inchSetted) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark1_temp.push(marker);
                }
            } else if (la2_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark2_temp.push(marker);
                }
            } else if (la3_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark3_temp.push(marker);
                }
            } else if (la4_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark4_temp.push(marker); 
                }
            } else if (la5_isClick) {
                if (vertextCnt > 0) {
                    if (pixelInchRatio != 0.0) {
                        var coords = line_midLatLng;
                        var marker = L.marker(coords, {
                            icon: L.divIcon({
                                html: feet_inch_str,
                                className: 'text-below-marker',
                            })
                        }).addTo(map);
                        marker.status = 1;
                    }
                    mark5_temp.push(marker); 
                }
            }
        });

        map.on('draw:created', function (e) {
            var type = e.layerType;
            polygon = e.layer;

            drawnItems.addLayer(polygon);
            map.removeLayer(drawnItems);

            drawnItems = null;
            drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);
            if (la1_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark1_temp.push(marker);
                layer1.push(polygon._latlngs);  
                layer1_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark1_temp.push(area);
                mark1.push(mark1_temp);
                mark1_temp = [];

                var polyline = null;
                var count = layer1.length - 1;
                for (var j = 0; j < layer1[count].length - 1; j ++) {
                    polyline = L.polyline([layer1[count][j], layer1[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer1_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark1[e.target.pgindex][e.target.index]);
                            mark1[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1]);
                            mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark1[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark1[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark1[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });

                    if (j == layer1[count].length - 2) {
                        polyline = L.polyline([layer1[count][j + 1], layer1[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer1_lines.push(polyline);

                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark1[e.target.pgindex][e.target.index + 1]);
                                mark1[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1]);
                                mark1[e.target.pgindex][mark1[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer1_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark1[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark1[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark1[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la2_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark2_temp.push(marker);
                layer2.push(polygon._latlngs);
                layer2_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark2_temp.push(area);
                mark2.push(mark2_temp);
                mark2_temp = [];

                var polyline = null;
                var count = layer2.length - 1;
                for (var j = 0; j < layer2[count].length - 1; j ++) {
                    polyline = L.polyline([layer2[count][j], layer2[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer2_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark2[e.target.pgindex][e.target.index]);
                            mark2[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1]);
                            mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer2_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark2[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark2[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark2[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer2[count].length - 2) {
                        polyline = L.polyline([layer2[count][j + 1], layer2[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer2_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark2[e.target.pgindex][e.target.index + 1]);
                                mark2[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1]);
                                mark2[e.target.pgindex][mark2[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer2_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark2[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark2[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark2[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la3_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark3_temp.push(marker);
                layer3.push(polygon._latlngs);  
                layer3_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark3_temp.push(area);
                mark3.push(mark3_temp);
                mark3_temp = [];

                var polyline = null;
                var count = layer3.length - 1;
                for (var j = 0; j < layer3[count].length - 1; j ++) {
                    polyline = L.polyline([layer3[count][j], layer3[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer3_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark3[e.target.pgindex][e.target.index]);
                            mark3[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1]);
                            mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer3_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark3[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark3[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark3[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer3[count].length - 2) {
                        polyline = L.polyline([layer3[count][j + 1], layer3[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer3_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark3[e.target.pgindex][e.target.index + 1]);
                                mark3[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1]);
                                mark3[e.target.pgindex][mark3[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer3_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark3[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark3[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark3[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la4_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark4_temp.push(marker);
                layer4.push(polygon._latlngs); 
                layer4_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark4_temp.push(area);
                mark4.push(mark4_temp);
                mark4_temp = [];

                var polyline = null;
                var count = layer4.length - 1;
                for (var j = 0; j < layer4[count].length - 1; j ++) {
                    var polyline = L.polyline([layer4[count][j], layer4[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer4_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark4[e.target.pgindex][e.target.index]);
                            mark4[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1]);
                            mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer4_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark4[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark4[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark4[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer4[count].length - 2) {
                        polyline = L.polyline([layer4[count][j + 1], layer4[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer4_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark4[e.target.pgindex][e.target.index + 1]);
                                mark4[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1]);
                                mark4[e.target.pgindex][mark4[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer4_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark4[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark4[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark4[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            } else if (la5_isClick) {
                if (pixelInchRatio != 0.0) {
                    var coords = line_midLatLng;
                    var marker = L.marker(coords, {
                        icon: L.divIcon({
                            html: feet_inch_str,
                            className: 'text-below-marker',
                        })
                    }).addTo(map);
                    marker.status = 1;
                }
                mark5_temp.push(marker);
                layer5.push(polygon._latlngs);  
                layer5_polygon.push(polygon);

                var polygonCenter = polygon.getBounds().getCenter();
                polygonCenter.lng = polygonCenter.lng - offset;

                var area = L.marker(polygonCenter, {
                    icon: L.divIcon({
                        html: polygonArea + "sqft",
                        className: 'text-below-marker',
                    })
                }).addTo(map);
                area.status = 1;
                mark5_temp.push(area);
                mark5.push(mark5_temp);
                mark5_temp = [];

                var polyline = null;
                var count = layer5.length - 1;
                for (var j = 0; j < layer5[count].length - 1; j ++) {
                    polyline = L.polyline([layer5[count][j], layer5[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    layer5_lines.push(polyline);
                    polyline.on('click', function(e) {
                        if (deleteEdgeStatus) {
                            e.target.status = 0;
                            map.removeLayer(e.target);

                            map.removeLayer(mark5[e.target.pgindex][e.target.index]);
                            mark5[e.target.pgindex][e.target.index].status = 0;

                            map.removeLayer(mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1]);
                            mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1].status = 0;

                            deleteEdgeStatus = !deleteEdgeStatus;
                            changeLineStatus = false;
                        }

                        if (changeLineStatus) {
                            var polygon = layer5_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length > 1)
                                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                else
                                    original_length = parseInt(original_length[0])*12;
                                var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                
                                var original_latlng = mark5[e.target.pgindex][e.target.index]._latlng;
                                map.removeLayer(mark5[e.target.pgindex][e.target.index]);
                                var marker = L.marker(original_latlng, {
                                    icon: L.divIcon({
                                        html: new_length,
                                        className: 'text-below-marker',
                                    })
                                }).addTo(map);
                                marker.status = 1;
                                mark5[e.target.pgindex][e.target.index] = marker;

                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                    
                    if (j == layer5[count].length - 2) {
                        polyline = L.polyline([layer5[count][j + 1], layer5[count][0]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);                         
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        layer5_lines.push(polyline);
                        
                        polyline.on('click', function(e) {
                            if (deleteEdgeStatus) {
                                e.target.status = 0;
                                map.removeLayer(e.target);

                                map.removeLayer(mark5[e.target.pgindex][e.target.index + 1]);
                                mark5[e.target.pgindex][e.target.index + 1].status = 0;

                                map.removeLayer(mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1]);
                                mark5[e.target.pgindex][mark5[e.target.pgindex].length - 1].status = 0;

                                deleteEdgeStatus = !deleteEdgeStatus;
                                changeLineStatus = false;
                            }

                            if (changeLineStatus) {
                                var polygon = layer5_polygon[e.target.pgindex];
                                var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                                if (polygon_pitch == 0) {
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length > 1)
                                        original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                                    else
                                        original_length = parseInt(original_length[0])*12;
                                    var new_length = Math.round(Math.sqrt(Math.pow(12, 2) + Math.pow(polygon_pitch, 2))/12 * original_length);
                                    new_length = Math.floor(new_length/12) + "ft" + " " + new_length%12 + "in"
                                    
                                    var original_latlng = mark5[e.target.pgindex][e.target.index + 1]._latlng;
                                    map.removeLayer(mark5[e.target.pgindex][e.target.index + 1]);
                                    var marker = L.marker(original_latlng, {
                                        icon: L.divIcon({
                                            html: new_length,
                                            className: 'text-below-marker',
                                        })
                                    }).addTo(map);
                                    marker.status = 1;
                                    mark5[e.target.pgindex][e.target.index + 1] = marker;

                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                }
                            }
                        });
                    }
                }
            }
        });

        uploadModal.style.display = "none";
        firstModal.style.display = "block";
    }
</script>
@endsection
