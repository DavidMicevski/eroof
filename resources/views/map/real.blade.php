@extends('map.base')

@section('action-content')
<div class="row">
    <div class="panel panel-default" style="border-top: none; background-color: #f8f8f8;">
        <form id="pitch_form" class="form-horizontal" role="form" method="POST" action="{{ route('map.pitch') }}" target="_blank">
            {{ csrf_field() }}    
            <input type="hidden" id="lat" name="lat" value="{{$lat}}">
            <input type="hidden" id="lng" name="lng" value="{{$lng}}">
        </form>
        <div id="layer-tool" class="col-md-1">
            <div class="row">
                <div class="col-md-9 area-region">
                    <span>Total SQ. FT.</span>
                    <p id="totalArea">0</p>
                </div>

                <div class="col-md-9">
                    <svg id="my-svg" style="display: none;"></svg>
                    <div id="d" style="display: none;"></div>
                    <canvas id="c" style="display: none;"></canvas>
                    <svg id="my-svg1" style="display: none;"></svg>
                    <div id="d1" style="display: none;"></div>
                    <canvas id="c1" style="display: none;"></canvas>
                    <svg id="my-svg2" style="display: none;"></svg>
                    <div id="d2" style="display: none;"></div>
                    <canvas id="c2" style="display: none;"></canvas>
                    <svg id="my-svg3" style="display: none;"></svg>
                    <div id="d3" style="display: none;"></div>
                    <canvas id="c3" style="display: none;"></canvas>
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
                <!-- <div class="col-md-5">
                    <a id="right" href="#" onclick="hideToolbar();"><i class="fa fa-angle-right"></i></a>
                    <a id="left" href="#" onclick="showToolbar();" class="hidden"><i class="fa fa-angle-left"></i></a>
                </div> -->
            </div>
            <button class="col-md-12" id="normal_draw" style="padding-left: 25px">
                <div class="col-md-4" style="line-height: 2">
                    <i class="icon icon-draw" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/draw-icon.svg") }}&quot;) center center no-repeat;"></i>
                </div>
                <div class="col-md-8" style="padding-left: 0px">
                    <p id="tool-name">Draw</p>
                </div>
            </button>
            <button class="col-md-12" id="move_anchor" style="padding-left: 25px">
                <div class="col-md-4" style="line-height: 2">
                    <i class="icon icon-draw" style="background: url(&quot;{{ asset("/bower_components/AdminLTE/dist/img/move-cursor-icon.svg") }}&quot;) center center no-repeat;"></i>
                </div>
                <div class="col-md-8" style="padding-left: 0px">
                    <p id="tool-name">Move Anchor Point</p>
                </div>
            </button>
            <button class="col-md-12" id="delete_edge" onclick="deleteEdge()">
                <div class="col-md-4">
                    <i class="fa fa-times-circle-o"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Delete Edge</p>
                </div>
            </button>
            <button class="col-md-12" id="delete_all_edge" onclick="deleteAllEdges()">
                <div class="col-md-4">
                    <i class="fa fa-trash-o"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Delete All Edges</p>
                </div>
            </button>
            <button class="col-md-12" id="reset_scale">
                <div class="col-md-4">
                    <i class="fa fa-times-circle-o"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Reset Scaling</p>
                </div>
            </button>
            <button class="col-md-12" id="upload_img">
                <div class="col-md-4">
                    <i class="fa fa-external-link"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Upload Image</p>
                </div>
            </button>
        </div>

        <div id="right_tool_bar" class="col-md-2 edges hidden">
            <div id="draw_tools">
                <div id="name" class="col-md-7">
                    <span id="tool-name">Edges Tools</span>
                </div>
                <!-- <div class="col-md-5">
                    <a id="right" href="#" onclick="hideToolbar();"><i class="fa fa-angle-right"></i></a>
                    <a id="left" href="#" onclick="showToolbar();" class="hidden"><i class="fa fa-angle-left"></i></a>
                </div> -->
            </div>
            <button class="col-md-12" id="eaves" onclick="changeEdge('#71bf82', 'Eaves')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #71bf82"></i>
                </div>
                <div class="col-md-8">
                    <p>Eaves</p>
                </div>
            </button>
            <button class="col-md-12" id="valleys" onclick="changeEdge('#f0512e', 'Valleys')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #f0512e"></i>
                </div>
                <div class="col-md-8">
                    <p>Valleys</p>
                </div>
            </button>
            <button class="col-md-12" id="hips" onclick="changeEdge('#9368b7', 'Hips')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #9368b7"></i>
                </div>
                <div class="col-md-8">
                    <p>Hips</p>
                </div>
            </button>
            <button class="col-md-12" id="ridges" onclick="changeEdge('#d0efb1', 'Ridges')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #d0efb1"></i>
                </div>
                <div class="col-md-8">
                    <p>Ridges</p>
                </div>
            </button>
            <button class="col-md-12" id="rakes" onclick="changeEdge('#ffa500', 'Rakes')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #ffa500"></i>
                </div>
                <div class="col-md-8">
                    <p>Rakes</p>
                </div>
            </button>
            <button class="col-md-12" id="wall" onclick="changeEdge('#4187af', 'Wall_Flashing')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #4187af"></i>
                </div>
                <div class="col-md-8">
                    <p>Wall Flashing</p>
                </div>
            </button>
            <button class="col-md-12" id="step" onclick="changeEdge('#ffcc0f', 'Step_Flashing')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #ffcc0f"></i>
                </div>
                <div class="col-md-8">
                    <p>Step Flashing</p>
                </div>
            </button>
            <button class="col-md-12" id="transition" onclick="changeEdge('#fb68ff', 'Transition')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #fb68ff"></i>
                </div>
                <div class="col-md-8">
                    <p>Transition</p>
                </div>
            </button>
            <button class="col-md-12" id="unspec" onclick="changeEdge('#55d3fc', 'Unspecified')">
                <div id="item" class="col-md-4">
                    <i class="edge" style="background-color: #55d3fc"></i>
                </div>
                <div class="col-md-8">
                    <p>Unspecified</p>
                </div>
            </button>
            <button class="col-md-12" id="delete_edge" onclick="deleteEdge()">
                <div class="col-md-4" style="padding-left: 30px">
                    <i class="fa fa-times-circle-o"></i>
                </div>
                <div class="col-md-8" style="padding-left: 25px">
                    <p id="tool-name">Delete Edge</p>
                </div>
            </button>
            <button class="col-md-12" id="delete_all_edge" onclick="deleteAllEdges()">
                <div class="col-md-4" style="padding-left: 30px">
                    <i class="fa fa-trash-o"></i>
                </div>
                <div class="col-md-8" style="padding-left: 25px">
                    <p id="tool-name">Delete All Edges</p>
                </div>
            </button>
        </div>

        <div id="right_tool_bar" class="col-md-2 facets hidden">
            <div id="draw_tools">
                <div id="name" class="col-md-7">
                    <span id="tool-name">Facets Tools</span>
                </div>
                <!-- <div class="col-md-5">
                    <a id="right" href="#" onclick="hideToolbar();"><i class="fa fa-angle-right"></i></a>
                    <a id="left" href="#" onclick="showToolbar();" class="hidden"><i class="fa fa-angle-left"></i></a>
                </div> -->
            </div>
            <button class="col-md-12" id="delete_facet" onclick="deleteFacet()">
                <div class="col-md-4">
                    <i class="fa fa-times-circle-o"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Delete Facet</p>
                </div>
            </button>
            <button class="col-md-12" id="delete_pitch" onclick="deletePitch()">
                <div class="col-md-4">
                    <i class="fa fa-times-circle-o"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Delete Pitch</p>
                </div>
            </button>
            <button class="col-md-12" id="delete_all_edge" onclick="deleteAllPitches()">
                <div class="col-md-4">
                    <i class="fa fa-trash-o"></i>
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Delete All Pitches</p>
                </div>
            </button>
            <button class="col-md-12" id="sp_mark" onclick="changeLabelMarker('DR')">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Dormer</p>
                </div>
            </button>
            <button class="col-md-12" id="sp_mark" onclick="changeLabelMarker('TS')">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Two Story</p>
                </div>
            </button>
            <button class="col-md-12" id="sp_mark" onclick="changeLabelMarker('TL')">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Two Layer</p>
                </div>
            </button>
            <button class="col-md-12" id="sp_mark" onclick="changeLabelMarker('LS')">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-8">
                    <p id="tool-name">Low Slope</p>
                </div>
            </button>
        </div>

        <div class="col-md-1 zoom-rotate">
            <div class="col-md-12 zoom">
                <a class="btn cancel" style="border: none; width: 47%; color: #fff; padding-left: 0; padding-right: 0" onclick="zoomin()" title="Zoom In">ZoomIn</a>
                <a class="btn cancel" style="border: none; width: 50%; color: #fff; padding-left: 0; padding-right: 0" onclick="zoomout()" title="Zoom Out">ZoomOut</a> 
            </div>
            <!-- <div class="col-md-12 rorate">
                <a class="btn cancel" style="border: none; width: 20%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateleft(-1)" title="Rotate Left (1 degree)">L1</a>
                <a class="btn cancel" style="border: none; width: 25%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateleft(-10)" title="Rotate Left (10 degrees)">L10</a>
                <a class="btn cancel" style="border: none; width: 25%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateright(10)" title="Rotate Right (10 degrees)">R10</a>
                <a class="btn cancel" style="border: none; width: 22%; color: #fff; padding-left: 0; padding-right: 0" onclick="rotateright(1)" title="Rotate Right (1 degree)">R1</a>
            </div>        -->
        </div>

        <div class="col-md-2 tool-bar">
            <!-- <div class="col-md-12 save">
                <a class="btn cancel" style="border: none; width: 47%; color: #fff" title="Cancel">Cancel</a>
                <a class="btn cancel" style="border: none; width: 50%; color: #fff" title="Save">Save</a>
            </div>
            <div class="col-md-12 undo">
                <a class="btn cancel" style="border: none; width: 47%; color: #fff" title="Undo">Undo</a>
                <a class="btn cancel" style="border: none; width: 50%; color: #fff" title="Redo">Redo</a>
            </div> -->
            <div class="col-md-12 tools">
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
                <input type="hidden" id="top_image" name="top_image">
                <input type="hidden" id="total-area" name="total-area">
                <input type="hidden" id="tsArea" name="tsArea">
                <input type="hidden" id="tlArea" name="tlArea">
                <input type="hidden" id="lsArea" name="lsArea">

                <input type="hidden" id="polygonAreas" name="polygonAreas[]">                

                <input type="hidden" id="eave" name="eaves">
                <input type="hidden" id="valley" name="valleys">
                <input type="hidden" id="hip" name="hips">
                <input type="hidden" id="ridge" name="ridges">
                <input type="hidden" id="rake" name="rakes">
                <input type="hidden" id="wall_flashing" name="wall_flashing">
                <input type="hidden" id="step_flahsing" name="step_flahsing">
                <input type="hidden" id="unspecified" name="unspecified">

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
                <input type="hidden" id="ele_twel" name="ele_twel">
                <input type="hidden" id="twel_twel" name="twel_twel">
                <input type="hidden" id="thirteen_twel" name="thirteen_twel">
                <input type="hidden" id="fourteen_twel" name="fourteen_twel">
                <input type="hidden" id="fifteen_twel" name="fifteen_twel">
                <input type="hidden" id="sixteen_twel" name="sixteen_twel">
                <input type="hidden" id="seventeen_twel" name="seventeen_twel">
                <input type="hidden" id="eighteen_twel" name="eighteen_twel">
                <input type="hidden" id="nineteen_twel" name="nineteen_twel">
                <input type="hidden" id="twenty_twel" name="twenty_twel">
                <input type="hidden" id="twentyone_twel" name="twentyone_twel">
                <input type="hidden" id="twentytwo_twel" name="twentytwo_twel">
                <input type="hidden" id="twentythree_twel" name="twentythree_twel">
                <input type="hidden" id="twentyfour_twel" name="twentyfour_twel">
                <input type="hidden" id="twentyfive_twel" name="twentyfive_twel">
                <input type="hidden" id="twentysix_twel" name="twentysix_twel">
                <input type="hidden" id="twentyseven_twel" name="twentyseven_twel">
                <input type="hidden" id="twentyeight_twel" name="twentyeight_twel">
                <input type="hidden" id="twentynine_twel" name="twentynine_twel">
                <input type="hidden" id="thirty_twel" name="thirty_twel">
                <input type="hidden" id="thirtyone_twel" name="thirtyone_twel">
                <input type="hidden" id="thirtytwo_twel" name="thirtytwo_twel">
                <input type="hidden" id="thirtythree_twel" name="thirtythree_twel">
                <input type="hidden" id="thirtyfour_twel" name="thirtyfour_twel">
                <input type="hidden" id="thirtyfive_twel" name="thirtyfive_twel">
                <input type="hidden" id="thirtysix_twel" name="thirtysix_twel">
                <input type="hidden" id="thirtyseven_twel" name="thirtyseven_twel">
                <input type="hidden" id="thirtyeight_twel" name="thirtyeight_twel">
                <input type="hidden" id="thirtynine_twel" name="thirtynine_twel">
                <input type="hidden" id="fourty_twel" name="fourty_twel">
                <input type="hidden" id="fourtyone_twel" name="fourtyone_twel">
                <input type="hidden" id="fourtytwo_twel" name="fourtytwo_twel">
                <input type="hidden" id="fourtythree_twel" name="fourtythree_twel">
                <input type="hidden" id="fourtyfour_twel" name="fourtyfour_twel">
                <input type="hidden" id="fourtyfive_twel" name="fourtyfive_twel">
                <input type="hidden" id="fourtysix_twel" name="fourtysix_twel">
                <input type="hidden" id="fourtyseven_twel" name="fourtyseven_twel">
                <input type="hidden" id="fourtyeigth_twel" name="fourtyeigth_twel">
                <input type="hidden" id="fourtynine_twel" name="fourtynine_twel">
                <input type="hidden" id="fifty_twel" name="fifty_twel">
                <input type="hidden" id="fiftyone_twel" name="fiftyone_twel">
                <input type="hidden" id="fiftytwo_twel" name="fiftytwo_twel">
                <input type="hidden" id="fiftythree_twel" name="fiftythree_twel">
                <input type="hidden" id="fiftyfour_twel" name="fiftyfour_twel">
                <input type="hidden" id="fiftyfive_twel" name="fiftyfive_twel">
                <input type="hidden" id="fiftysix_twel" name="fiftysix_twel">
                <input type="hidden" id="fiftyseven_twel" name="fiftyseven_twel">
                <input type="hidden" id="fiftyeight_twel" name="fiftyeight_twel">
                <input type="hidden" id="fiftynine_twel" name="fiftynine_twel">
                <input type="hidden" id="sixty_twel" name="sixty_twel">
                <input type="hidden" id="sixtyone_twel" name="sixtyone_twel">
                <input type="hidden" id="sixtytwo_twel" name="sixtytwo_twel">
                <input type="hidden" id="sixtythree_twel" name="sixtythree_twel">
                <input type="hidden" id="sixtyfour_twel" name="sixtyfour_twel">
                <input type="hidden" id="sixtyfive_twel" name="sixtyfive_twel">
                <input type="hidden" id="sixtysix_twel" name="sixtysix_twel">
                <input type="hidden" id="sixtyseven_twel" name="sixtyseven_twel">
                <input type="hidden" id="sixtyeight_twel" name="sixtyeight_twel">
                <input type="hidden" id="sixtynine_twel" name="sixtynine_twel">
                <input type="hidden" id="seventy_twel" name="seventy_twel">
                <input type="hidden" id="seventyone_twel" name="seventyone_twel">
                <input type="hidden" id="seventytwo_twel" name="seventytwo_twel">
                <input type="hidden" id="seventythree_twel" name="seventythree_twel">
                <input type="hidden" id="seventyfour_twel" name="seventyfour_twel">
                <input type="hidden" id="seventyfive_twel" name="seventyfive_twel">
                <input type="hidden" id="seventysix_twel" name="seventysix_twel">
                <input type="hidden" id="seventyseven_twel" name="seventyseven_twel">
                <input type="hidden" id="seventyeight_twel" name="seventyeight_twel">
                <input type="hidden" id="seventynine_twel" name="seventynine_twel">
                <input type="hidden" id="eighty_twel" name="eighty_twel">
                <input type="hidden" id="eightyone_twel" name="eightyone_twel">
                <input type="hidden" id="eightytwo_twel" name="eightytwo_twel">
                <input type="hidden" id="eightythree_twel" name="eightythree_twel">
                <input type="hidden" id="eightyfour_twel" name="eightyfour_twel">
                <input type="hidden" id="eightyfive_twel" name="eightyfive_twel">
                <input type="hidden" id="eightysix_twel" name="eightysix_twel">
                <input type="hidden" id="eightyseven_twel" name="eightyseven_twel">
                <input type="hidden" id="eightyeight_twel" name="eightyeight_twel">
                <input type="hidden" id="eightynine_twel" name="eightynine_twel">
                <input type="hidden" id="ninety_twel" name="ninety_twel">
                <input type="hidden" id="ninetyone_twel" name="ninetyone_twel">
                <input type="hidden" id="ninetytwo_twel" name="ninetytwo_twel">
                <input type="hidden" id="ninetythree_twel" name="ninetythree_twel">
                <input type="hidden" id="ninetyfour_twel" name="ninetyfour_twel">
                <input type="hidden" id="ninetyfive_twel" name="ninetyfive_twel">
                <input type="hidden" id="ninetysix_twel" name="ninetysix_twel">
                <input type="hidden" id="ninetyseven_twel" name="ninetyseven_twel">
                <input type="hidden" id="ninetyeight_twel" name="ninetyeight_twel">
                <input type="hidden" id="ninetynine_twel" name="ninetynine_twel">
                <input type="hidden" id="hundred_twel" name="hundred_twel">
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
                        <div class="col-md-4">
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
<script src="{{ asset('js/geometryutil.js') }}"></script>
<script src="{{ asset('js/leaflet.almostover.js') }}"></script>
<script type="text/javascript">
    var crossHairStatus = false;
    var pixelInchRatio1 = 0;
    var labelMarkers = [], changeLabelMarkerStatus = false, settedMark = "";
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
    var polylines = [], deleteEdgeStatus = false, lineColor = null, changeLineStatus = false, lineType = 'Unspecified';
    var removefacetStatus = false, setpitchStatus = false, removepitchStatus = false;;
    var layer1_lines = [], layer2_lines = [], layer3_lines = [], layer4_lines = [], layer5_lines = [];
    var layer1_polygon = [], layer2_polygon = [], layer3_polygon = [], layer4_polygon = [], layer5_polygon = [];
    var polygon = null, layer1 = [], layer2 = [], layer3 = [], layer4 = [], layer5 = [];
    var mark1 = [], mark2 = [], mark3 = [], mark4 = [], mark5 = [];
    var mark1_temp = [], mark2_temp = [], mark3_temp = [], mark4_temp = [], mark5_temp = [];
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
                maxZoom: 1,
                minZoom: -1,
            });
            map.doubleClickZoom.disable();
            var bounds = [[0, 0], [300, 300]];
            var filePath = "https://maps.googleapis.com/maps/api/staticmap?center={{$lat}},{{$lng}}&zoom={{$zoom}}&size=800x600&maptype=satellite&key={{env('GOOGLE_IMAGE_KEY')}}";
            $("#top_image").val("https://maps.googleapis.com/maps/api/staticmap?center={{$lat}},{{$lng}}&zoom={{$zoom}}&size=800x600&maptype=satellite&key={{env('GOOGLE_IMAGE_KEY')}}");
        } else if (type == "near") {
            map = L.map('map', {
                editable: true, 
                crs: L.CRS.Simple,
                maxZoom: 1,
                minZoom: -1,
            });
            map.doubleClickZoom.disable();
            var bounds = [[0, 0], [1280, 1024]];
            var filePath = "http://us0.nearmap.com/staticmap?center={{$lat}},{{$lng}}&size=800x600&zoom={{$zoom}}&httpauth=false&apikey={{env('NEAR_KEY')}}";
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

        //Make Facet tools
        for (var i = 0; i < 101; i ++) {
            $('.facets').append("<button class='col-md-12' id='pitch-btn' onclick='setPitch(" + i+""+ ")'> <div class='col-md-4'></div><div class='col-md-2'><p id='tool-name'>" + i+"/12" + "</p></div><div class='col-md-6'><i class='fa fa-arrows-alt' style='font-size: 12px'></i></div></button>");
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
            //--------Continue Draw Line After Finished Line
            myPolylineDrawHandler.disable();
            myPolylineDrawHandler.enable();
            //-------------------------------
            if (crossHairStatus) {
                $(".leaflet-mouse-marker").css ({
                    'cursor': 'none'
                });    
                
                $(".content-wrapper").css ({
                    'cursor': 'none'
                }); 
            }
            //--------
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer1.length - 1;
                for (var i = 0; i < layer1_lines.length; i ++) {
                    polyline = layer1_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer1[count].length - 1; j ++) {
                    polyline = L.polyline([layer1[count][j], layer1[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    // map.on('almost:over', function (e) {
                    //     $(".leaflet-mouse-marker").css ({
                    //         'cursor': 'copy'
                    //     });
                    // });
                    // map.on('almost:out', function(e) {
                    //     crosshair();
                    // });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark1[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        // map.on('almost:over', function (e) {
                        //     $('html,body').css('cursor','crosshair');
                        // });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark1[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer2.length - 1;
                for (var i = 0; i < layer2_lines.length; i ++) {
                    polyline = layer2_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer2[count].length - 1; j ++) {
                    polyline = L.polyline([layer2[count][j], layer2[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark2[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark2[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer3.length - 1;
                for (var i = 0; i < layer3_lines.length; i ++) {
                    polyline = layer3_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer3[count].length - 1; j ++) {
                    polyline = L.polyline([layer3[count][j], layer3[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark3[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark3[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer4.length - 1;
                for (var i = 0; i < layer4_lines.length; i ++) {
                    polyline = layer4_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer4[count].length - 1; j ++) {
                    polyline = L.polyline([layer4[count][j], layer4[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark4[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark4[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer5.length - 1;
                for (var i = 0; i < layer5_lines.length; i ++) {
                    polyline = layer5_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer5[count].length - 1; j ++) {
                    polyline = L.polyline([layer5[count][j], layer5[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark5[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark5[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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
            disableMoveAnchor();
            var polygon = e.poly;
            if (la1_isClick) {
                var index = 0;
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
                for (var i = 0; i < layer1_lines.length; i ++) {
                    polyline = layer1_lines[i].addTo(map);
                    if (polyline.pgindex == editingPolyIndex) {
                        polyline.length = resList[index].feet_inch_str;
                        index ++;
                    }
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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

                                e.target.type = lineType;
                                e.target.length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
            } else if (la2_isClick) {
                var index = 0;
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
                for (var i = 0; i < layer2_lines.length; i ++) {
                    polyline = layer2_lines[i].addTo(map);
                    if (polyline.pgindex == editingPolyIndex) {
                        polyline.length = resList[index].feet_inch_str;
                        index ++;
                    }
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
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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

                                e.target.type = lineType;
                                e.target.length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
            } else if (la3_isClick) {
                var index = 0;
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
                for (var i = 0; i < layer3_lines.length; i ++) {
                    polyline = layer3_lines[i].addTo(map);
                    if (polyline.pgindex == editingPolyIndex) {
                        polyline.length = resList[index].feet_inch_str;
                        index ++;
                    }
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
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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

                                e.target.type = lineType;
                                e.target.length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
            } else if (la4_isClick) {
                var index = 0;
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
                for (var i = 0; i < layer4_lines.length; i ++) {
                    polyline = layer4_lines[i].addTo(map);
                    if (polyline.pgindex == editingPolyIndex) {
                        polyline.length = resList[index].feet_inch_str;
                        index ++;
                    }
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
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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

                                e.target.type = lineType;
                                e.target.length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
            } else if (la5_isClick) {
                var index = 0;
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
                for (var i = 0; i < layer5_lines.length; i ++) {
                    polyline = layer5_lines[i].addTo(map);
                    if (polyline.pgindex == editingPolyIndex) {
                        polyline.length = resList[index].feet_inch_str;
                        index ++;
                    }
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
                            var polygon = layer1_polygon[e.target.pgindex];
                            var polygon_pitch = (polygon.pitch == undefined) ? 0 : polygon.pitch;
                            if (polygon_pitch == 0) {
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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

                                e.target.type = lineType;
                                e.target.length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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

            $("#move_anchor").click();
        });

        //-----------------------Set Draw Button First
        $('#normal_draw').click();
        $('#normal_draw').focus();
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


        function handleMouseDown(e) {
            if (e.button === 2) {
                myPolylineDrawHandler.disable();
                var blockContextMenu, myElement;

                blockContextMenu = function (evt) {
                    evt.preventDefault();
                };

                myElement = document.querySelector('#map');
                myElement.addEventListener('contextmenu', blockContextMenu);
            }
        }

        function handleMouseUp(e) {
            if (e.button === 2)
                myPolylineDrawHandler.disable();
        }

        document.addEventListener('mousedown', handleMouseDown);
        document.addEventListener('mouseup', handleMouseUp);
    });

    function downloadType() {
        if ($("#download-type").val() == 1) {
            createImage();
        } else if ($("#download-type").val() == 2) {
            downloadCSV();
        } else if ($("#download-type").val() == 3) {

        }
    }

    function rotateright(value) {
        var imgstyleText = $('img')[1].style.cssText;
        var imgtransformVal = imgstyleText.split(';')[1];
        degree += value;
        var imgAngle = imgtransformVal + " " +  'rotate(' + value + 'deg)';

        $("#map").css({
            'transform': 'rotate(' + degree + 'deg)',
            'transform-origin': 'center'
        });
    }

    function rotateleft(value) {
        var styleText = $('img')[1].style.cssText;
        var transformVal = styleText.split(';')[1];
        degree += value;
        var imgAngle = transformVal + " " +  'rotate(' + value + 'deg)';

        $("#map").css({
            'transform': 'rotate(' + degree + 'deg)',
            'transform-origin': 'center'
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
        if (zoomLevel > 3)
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
        settedMark = label;
        changeLabelMarkerStatus = !changeLabelMarkerStatus;
    }

    function deleteEdge() {
        myPolylineDrawHandler.disable();
        disableMoveAnchor();
        deleteEdgeStatus = !deleteEdgeStatus;
    }

    function changeEdge(color, type) {
        lineType = type;
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

    function createImage() {
        var svg = $("#my-svg");
        svg.attr('width', 1592);
        svg.attr('height', 896);

        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].type == 'Unspecified' || layer1_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer1_lines[i]._originalPoints[0].x+layer1_lines[i]._originalPoints[1].x)/2+' '+(layer1_lines[i]._originalPoints[0].y+layer1_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer1_lines[i].color+'">'+layer1_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer1_lines[i]._originalPoints[0].x+layer1_lines[i]._originalPoints[1].x)/2+' '+(layer1_lines[i]._originalPoints[0].y+layer1_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer1_lines[i].color+'">'+layer1_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            }
        }

        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].type == 'Unspecified' || layer2_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer2_lines[i]._originalPoints[0].x+layer2_lines[i]._originalPoints[1].x)/2+' '+(layer2_lines[i]._originalPoints[0].y+layer2_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer2_lines[i].color+'">'+layer2_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer2_lines[i]._originalPoints[0].x+layer2_lines[i]._originalPoints[1].x)/2+' '+(layer2_lines[i]._originalPoints[0].y+layer2_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer2_lines[i].color+'">'+layer2_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            }
        }

        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].type == 'Unspecified' || layer3_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer3_lines[i]._originalPoints[0].x+layer3_lines[i]._originalPoints[1].x)/2+' '+(layer3_lines[i]._originalPoints[0].y+layer3_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer3_lines[i].color+'">'+layer3_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer3_lines[i]._originalPoints[0].x+layer3_lines[i]._originalPoints[1].x)/2+' '+(layer3_lines[i]._originalPoints[0].y+layer3_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer3_lines[i].color+'">'+layer3_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            }
        }

        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].type == 'Unspecified' || layer4_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer4_lines[i]._originalPoints[0].x+layer4_lines[i]._originalPoints[1].x)/2+' '+(layer4_lines[i]._originalPoints[0].y+layer4_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer4_lines[i].color+'">'+layer4_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer4_lines[i]._originalPoints[0].x+layer4_lines[i]._originalPoints[1].x)/2+' '+(layer4_lines[i]._originalPoints[0].y+layer4_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer4_lines[i].color+'">'+layer4_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            }
        }

        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].type == 'Unspecified' || layer5_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer5_lines[i]._originalPoints[0].x+layer5_lines[i]._originalPoints[1].x)/2+' '+(layer5_lines[i]._originalPoints[0].y+layer5_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer5_lines[i].color+'">'+layer5_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                var length = '<g transform="translate('+(layer5_lines[i]._originalPoints[0].x+layer5_lines[i]._originalPoints[1].x)/2+' '+(layer5_lines[i]._originalPoints[0].y+layer5_lines[i]._originalPoints[1].y)/2+')"><text fill="'+layer5_lines[i].color+'">'+layer5_lines[i].length+'</text></g>';
                svg.append(line);
                svg.append(length);
            }
        }

        var width = 0, height = 0;
        var text = document.getElementById('my-svg').outerHTML;
        text.wrap = 'off';
        var svg = null;

        var div = document.getElementById('d');
        div.innerHTML= text;
        svg = div.querySelector('svg');
        width = 1300;
        height = 1300;
        
        var canvas = document.getElementById('c');
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        canvas.width = width;
        canvas.height = height;
        var data = new XMLSerializer().serializeToString(svg);
        var win = window.URL || window.webkitURL || window;
        var img = new Image();
        var blob = new Blob([data], { type: 'image/svg+xml' });
        var url = win.createObjectURL(blob);
        img.onload = function () {
            canvas.getContext('2d').drawImage(img, 0, 0);
            win.revokeObjectURL(url);
            var uri = canvas.toDataURL('image/jpg').replace('image/jpg', 'octet/stream');
            var token = '{{csrf_field()}}'.split('value="');
            token = token[1].split('">');
            
            $.ajax({
                url: '/map/uploadImage',
                type: 'post',
                data: {
                    _token: token[0],
                    imagedata: uri,
                    imagename: 'image005_1.jpg'
                },
                success: function(res) {
                    createImage1();
                }
            });
        };
        img.src = url;
    }

    function createImage1() {
        var svg = $("#my-svg1");
        svg.attr('width', 1592);
        svg.attr('height', 896);

        for (var i = 0; i < mark1.length; i ++) {
            var area = '<g transform="translate('+mark1[i][mark1[i].length - 1]._icon._leaflet_pos.x+' '+mark1[i][mark1[i].length - 1]._icon._leaflet_pos.y+')"><text>'+parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html)+'</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark2.length; i ++) {
            var area = '<g transform="translate('+mark2[i][mark2[i].length - 1]._icon._leaflet_pos.x+' '+mark2[i][mark2[i].length - 1]._icon._leaflet_pos.y+')"><text>'+parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html)+'</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark3.length; i ++) {
            var area = '<g transform="translate('+mark3[i][mark3[i].length - 1]._icon._leaflet_pos.x+' '+mark3[i][mark3[i].length - 1]._icon._leaflet_pos.y+')"><text>'+parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html)+'</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark4.length; i ++) {
            var area = '<g transform="translate('+mark4[i][mark4[i].length - 1]._icon._leaflet_pos.x+' '+mark4[i][mark4[i].length - 1]._icon._leaflet_pos.y+')"><text>'+parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html)+'</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark5.length; i ++) {
            var area = '<g transform="translate('+mark5[i][mark5[i].length - 1]._icon._leaflet_pos.x+' '+mark5[i][mark5[i].length - 1]._icon._leaflet_pos.y+')"><text>'+parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html)+'</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].type == 'Unspecified' || layer1_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].type == 'Unspecified' || layer2_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].type == 'Unspecified' || layer3_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].type == 'Unspecified' || layer4_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].type == 'Unspecified' || layer5_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        var width = 0, height = 0;
        var text = document.getElementById('my-svg1').outerHTML;
        text.wrap = 'off';
        var svg = null;

        var div = document.getElementById('d1');
        div.innerHTML= text;
        svg = div.querySelector('svg');
        width = 1300;
        height = 1300;
        
        var canvas = document.getElementById('c1');
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        canvas.width = width;
        canvas.height = height;
        var data = new XMLSerializer().serializeToString(svg);
        var win = window.URL || window.webkitURL || window;
        var img = new Image();
        var blob = new Blob([data], { type: 'image/svg+xml' });
        var url = win.createObjectURL(blob);
        img.onload = function () {
            canvas.getContext('2d').drawImage(img, 0, 0);
            win.revokeObjectURL(url);
            var uri = canvas.toDataURL('image/jpg').replace('image/jpg', 'octet/stream');

            var token = '{{csrf_field()}}'.split('value="');
            token = token[1].split('">');
            
            $.ajax({
                url: '/map/uploadImage',
                type: 'post',
                data: {
                    _token: token[0],
                    imagedata: uri,
                    imagename: 'image006_1.jpg'
                },
                success: function(res) {
                    createImage2();
                }
            });
        };
        img.src = url;
    }

    function createImage2() {
        var svg = $("#my-svg2");
        svg.attr('width', 1592);
        svg.attr('height', 896);

        for (var i = 0; i < mark1.length; i ++) {
            var area = '<g transform="translate('+mark1[i][mark1[i].length - 1]._icon._leaflet_pos.x+' '+mark1[i][mark1[i].length - 1]._icon._leaflet_pos.y+')"><text>6:12</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark2.length; i ++) {
            var area = '<g transform="translate('+mark2[i][mark2[i].length - 1]._icon._leaflet_pos.x+' '+mark2[i][mark2[i].length - 1]._icon._leaflet_pos.y+')"><text>6:12</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark3.length; i ++) {
            var area = '<g transform="translate('+mark3[i][mark3[i].length - 1]._icon._leaflet_pos.x+' '+mark3[i][mark3[i].length - 1]._icon._leaflet_pos.y+')"><text>6:12</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark4.length; i ++) {
            var area = '<g transform="translate('+mark4[i][mark4[i].length - 1]._icon._leaflet_pos.x+' '+mark4[i][mark4[i].length - 1]._icon._leaflet_pos.y+')"><text>6:12</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < mark5.length; i ++) {
            var area = '<g transform="translate('+mark5[i][mark5[i].length - 1]._icon._leaflet_pos.x+' '+mark5[i][mark5[i].length - 1]._icon._leaflet_pos.y+')"><text>6:12</text></g>';
            svg.append(area);
        }

        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].type == 'Unspecified' || layer1_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            }
        }

        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].type == 'Unspecified' || layer2_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            }
        }

        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].type == 'Unspecified' || layer3_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            }
        }

        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].type == 'Unspecified' || layer4_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            }
        }

        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].type == 'Unspecified' || layer5_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                svg.append(line);
            }
        }

        var width = 0, height = 0;
        var text = document.getElementById('my-svg2').outerHTML;
        text.wrap = 'off';
        var svg = null;

        var div = document.getElementById('d2');
        div.innerHTML= text;
        svg = div.querySelector('svg');
        width = 1300;
        height = 1300;
        
        var canvas = document.getElementById('c2');
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        canvas.width = width;
        canvas.height = height;
        var data = new XMLSerializer().serializeToString(svg);
        var win = window.URL || window.webkitURL || window;
        var img = new Image();
        var blob = new Blob([data], { type: 'image/svg+xml' });
        var url = win.createObjectURL(blob);
        img.onload = function () {
            canvas.getContext('2d').drawImage(img, 0, 0);
            win.revokeObjectURL(url);
            var uri = canvas.toDataURL('image/jpg').replace('image/jpg', 'octet/stream');

            var token = '{{csrf_field()}}'.split('value="');
            token = token[1].split('">');
            
            $.ajax({
                url: '/map/uploadImage',
                type: 'post',
                data: {
                    _token: token[0],
                    imagedata: uri,
                    imagename: 'image007_1.jpg'
                },
                success: function(res) {
                    createImage3();
                }
            });
        };
        img.src = url;
    }

    function createImage3() {
        var polygonAreas = [];
        var svg = $("#my-svg3");
        svg.attr('width', 1592);
        svg.attr('height', 896);

        var pointsArr = '';
        for (var i = 0; i < layer1_lines.length; i ++) {
            var points = layer1_lines[i]._originalPoints[0].x + ' ' + layer1_lines[i]._originalPoints[0].y + ' ' + layer1_lines[i]._originalPoints[1].x + ' ' + layer1_lines[i]._originalPoints[1].y + ' ';
            pointsArr += points;
        }

        var polygon =  '<polygon points="' + pointsArr + '"' + ' ' + 'fill="#c0c0c0"/>';
        svg.append(polygon);

        pointsArr = '';
        for (var i = 0; i < layer2_lines.length; i ++) {
            var points = layer2_lines[i]._originalPoints[0].x + ' ' + layer2_lines[i]._originalPoints[0].y + ' ' + layer2_lines[i]._originalPoints[1].x + ' ' + layer2_lines[i]._originalPoints[1].y + ' ';
            pointsArr += points;
        }

        var polygon =  '<polygon points="' + pointsArr + '"' + ' ' + 'fill="#c0c0c0"/>';
        svg.append(polygon);

        pointsArr = '';
        for (var i = 0; i < layer3_lines.length; i ++) {
            var points = layer3_lines[i]._originalPoints[0].x + ' ' + layer3_lines[i]._originalPoints[0].y + ' ' + layer3_lines[i]._originalPoints[1].x + ' ' + layer3_lines[i]._originalPoints[1].y + ' ';
            pointsArr += points;
        }

        var polygon =  '<polygon points="' + pointsArr + '"' + ' ' + 'fill="#c0c0c0"/>';
        svg.append(polygon);

        pointsArr = '';
        for (var i = 0; i < layer4_lines.length; i ++) {
            var points = layer4_lines[i]._originalPoints[0].x + ' ' + layer4_lines[i]._originalPoints[0].y + ' ' + layer4_lines[i]._originalPoints[1].x + ' ' + layer4_lines[i]._originalPoints[1].y + ' ';
            pointsArr += points;
        }

        var polygon =  '<polygon points="' + pointsArr + '"' + ' ' + 'fill="#c0c0c0"/>';
        svg.append(polygon);

        pointsArr = '';
        for (var i = 0; i < layer5_lines.length; i ++) {
            var points = layer5_lines[i]._originalPoints[0].x + ' ' + layer5_lines[i]._originalPoints[0].y + ' ' + layer5_lines[i]._originalPoints[1].x + ' ' + layer5_lines[i]._originalPoints[1].y + ' ';
            pointsArr += points;
        }

        var polygon =  '<polygon points="' + pointsArr + '"' + ' ' + 'fill="#c0c0c0"/>';
        svg.append(polygon);

        var index = 0;
        for (var i = 0; i < mark1.length; i ++) {
            var area = '<g transform="translate('+mark1[i][mark1[i].length - 1]._icon._leaflet_pos.x+' '+mark1[i][mark1[i].length - 1]._icon._leaflet_pos.y+')"><text fill="black">'+String.fromCharCode(index+65)+'</text></g>';
            svg.append(area);
            polygonAreas.push(parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html));
            index ++;
        }
        for (var i = 0; i < mark2.length; i ++) {
            var area = '<g transform="translate('+mark2[i][mark2[i].length - 1]._icon._leaflet_pos.x+' '+mark2[i][mark2[i].length - 1]._icon._leaflet_pos.y+')"><text fill="black">'+String.fromCharCode(index+65)+'</text></g>';
            svg.append(area);
            polygonAreas.push(parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html));
            index ++;
        }
        for (var i = 0; i < mark3.length; i ++) {
            var area = '<g transform="translate('+mark3[i][mark3[i].length - 1]._icon._leaflet_pos.x+' '+mark3[i][mark3[i].length - 1]._icon._leaflet_pos.y+')"><text fill="black">'+String.fromCharCode(index+65)+'</text></g>';
            svg.append(area);
            polygonAreas.push(parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html));
            index ++;
        }
        for (var i = 0; i < mark4.length; i ++) {
            var area = '<g transform="translate('+mark4[i][mark4[i].length - 1]._icon._leaflet_pos.x+' '+mark4[i][mark4[i].length - 1]._icon._leaflet_pos.y+')"><text fill="black">'+String.fromCharCode(index+65)+'</text></g>';
            svg.append(area);
            polygonAreas.push(parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html));
            index ++;
        }
        for (var i = 0; i < mark5.length; i ++) {
            var area = '<g transform="translate('+mark5[i][mark5[i].length - 1]._icon._leaflet_pos.x+' '+mark5[i][mark5[i].length - 1]._icon._leaflet_pos.y+')"><text fill="black">'+String.fromCharCode(index+65)+'</text></g>';
            svg.append(area);
            polygonAreas.push(parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html));
            index ++;
        }

        $("#polygonAreas").val(polygonAreas);

        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].type == 'Unspecified' || layer1_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer1_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer1_lines[i]._originalPoints[0].x+' '+layer1_lines[i]._originalPoints[0].y+'L'+layer1_lines[i]._originalPoints[1].x+' '+layer1_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].type == 'Unspecified' || layer2_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer2_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer2_lines[i]._originalPoints[0].x+' '+layer2_lines[i]._originalPoints[0].y+'L'+layer2_lines[i]._originalPoints[1].x+' '+layer2_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].type == 'Unspecified' || layer3_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer3_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer3_lines[i]._originalPoints[0].x+' '+layer3_lines[i]._originalPoints[0].y+'L'+layer3_lines[i]._originalPoints[1].x+' '+layer3_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].type == 'Unspecified' || layer4_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer4_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer4_lines[i]._originalPoints[0].x+' '+layer4_lines[i]._originalPoints[0].y+'L'+layer4_lines[i]._originalPoints[1].x+' '+layer4_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].type == 'Unspecified' || layer5_lines[i].type == 'Transition') {
                var line = '<g><path stroke-linejoin="round" stroke-dasharray="5, 5" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            } else {
                var line = '<g><path stroke-linejoin="round" stroke-linecap="round" stroke="'+layer5_lines[i].color+'" stroke-opacity="1" stroke-width="2" fill="none" d="M'+layer5_lines[i]._originalPoints[0].x+' '+layer5_lines[i]._originalPoints[0].y+'L'+layer5_lines[i]._originalPoints[1].x+' '+layer5_lines[i]._originalPoints[1].y+'"></path></g>';
                
                svg.append(line);
            }
        }

        var width = 0, height = 0;
        var text = document.getElementById('my-svg3').outerHTML;
        text.wrap = 'off';
        var svg = null;

        var div = document.getElementById('d3');
        div.innerHTML= text;
        svg = div.querySelector('svg');
        width = 1300;
        height = 1300;
        
        var canvas = document.getElementById('c3');
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        canvas.width = width;
        canvas.height = height;
        var data = new XMLSerializer().serializeToString(svg);
        var win = window.URL || window.webkitURL || window;
        var img = new Image();
        var blob = new Blob([data], { type: 'image/svg+xml' });
        var url = win.createObjectURL(blob);
        img.onload = function () {
            canvas.getContext('2d').drawImage(img, 0, 0);
            win.revokeObjectURL(url);
            var uri = canvas.toDataURL('image/jpg').replace('image/jpg', 'octet/stream');

            var token = '{{csrf_field()}}'.split('value="');
            token = token[1].split('">');
            
            $.ajax({
                url: '/map/uploadImage',
                type: 'post',
                data: {
                    _token: token[0],
                    imagedata: uri,
                    imagename: 'image008_1.jpg'
                },
                success: function(res) {
                    downloadPDF();
                }
            });
        };
        img.src = url;
    }

    function downloadCSV() {
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

        var lsArea = 0, tsArea = 0, tlArea = 0;

        for (var i = 0; i < layer1_polygon.length; i ++) {
            if (layer1_polygon[i].labelMarkers != undefined) {
                if (layer1_polygon[i].labelMarkers.indexOf("LS") != -1) {
                    var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                    lsArea += area;
                } 

                if (layer1_polygon[i].labelMarkers.indexOf("TS") != -1) {
                    var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                    tsArea += area;
                } 

                if (layer1_polygon[i].labelMarkers.indexOf("TL") != -1) {
                    var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                    tlArea += area;
                }
            }
        }

        for (var i = 0; i < layer2_polygon.length; i ++) {
            if (layer2_polygon[i].labelMarkers != undefined) {
                if (layer2_polygon[i].labelMarkers.indexOf("LS") != -1) {
                    var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                    lsArea += area;
                }

                if (layer2_polygon[i].labelMarkers.indexOf("TS") != -1) {
                    var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                    tsArea += area;
                }

                if (layer2_polygon[i].labelMarkers.indexOf("TL") != -1) {
                    var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                    tlArea += area;
                }
            }
        }

        for (var i = 0; i < layer3_polygon.length; i ++) {
            if (layer3_polygon[i].labelMarkers != undefined) {
                if (layer3_polygon[i].labelMarkers.indexOf("LS") != -1) {
                    var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                    lsArea += area;
                }

                if (layer3_polygon[i].labelMarkers.indexOf("TS") != -1) {
                    var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                    tsArea += area;
                }

                if (layer3_polygon[i].labelMarkers.indexOf("TL") != -1) {
                    var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                    tlArea += area;
                }
            }
        }

        for (var i = 0; i < layer4_polygon.length; i ++) {
            if (layer4_polygon[i].labelMarkers != undefined) {
                if (layer4_polygon[i].labelMarkers.indexOf("LS") != -1) {
                    var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                    lsArea += area;
                }

                if (layer4_polygon[i].labelMarkers.indexOf("TS") != -1) {
                    var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                    tsArea += area;
                }

                if (layer4_polygon[i].labelMarkers.indexOf("TL") != -1) {
                    var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                    tlArea += area;
                }
            }
        }

        for (var i = 0; i < layer5_polygon.length; i ++) {
            if (layer5_polygon[i].labelMarkers != undefined) {
                if (layer5_polygon[i].labelMarkers.indexOf("LS") != -1) {
                    var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                    lsArea += area;
                }

                if (layer5_polygon[i].labelMarkers.indexOf("TS") != -1) {
                    var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                    tsArea += area;
                }

                if (layer5_polygon[i].labelMarkers.indexOf("TL") != -1) {
                    var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                    tlArea += area;
                }
            }
        }

        $('#lsArea').val(lsArea + '');
        $('#tsArea').val(tsArea + '');
        $('#tlArea').val(tlArea + '');

        var eaves = 0, valleys = 0, hips = 0, ridges = 0, rakes = 0, wall_flashing = 0, step_flahsing = 0, unspecified = 0;
        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].type == "Eaves") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer1_lines[i].type == "Valleys") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer1_lines[i].type == "Hips") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer1_lines[i].type == "Ridges") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer1_lines[i].type == "Rakes") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer1_lines[i].type == "Wall_Flashing") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer1_lines[i].type == "Step_Flashing") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer1_lines[i].type == "Unspecified") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].type == "Eaves") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer2_lines[i].type == "Valleys") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer2_lines[i].type == "Hips") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer2_lines[i].type == "Ridges") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer2_lines[i].type == "Rakes") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer2_lines[i].type == "Wall_Flashing") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer2_lines[i].type == "Step_Flashing") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer2_lines[i].type == "Unspecified") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].type == "Eaves") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer3_lines[i].type == "Valleys") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer3_lines[i].type == "Hips") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer3_lines[i].type == "Ridges") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer3_lines[i].type == "Rakes") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer3_lines[i].type == "Wall_Flashing") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer3_lines[i].type == "Step_Flashing") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer3_lines[i].type == "Unspecified") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].type == "Eaves") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer4_lines[i].type == "Valleys") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer4_lines[i].type == "Hips") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer4_lines[i].type == "Ridges") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer4_lines[i].type == "Rakes") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer4_lines[i].type == "Wall_Flashing") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer4_lines[i].type == "Step_Flashing") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer4_lines[i].type == "Unspecified") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].type == "Eaves") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer5_lines[i].type == "Valleys") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer5_lines[i].type == "Hips") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer5_lines[i].type == "Ridges") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer5_lines[i].type == "Rakes") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer5_lines[i].type == "Wall_Flashing") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer5_lines[i].type == "Step_Flashing") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer5_lines[i].type == "Unspecified") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        eaves = Math.floor(eaves/12) + "ft" + " " + eaves%12 + "in";
        valleys = Math.floor(valleys/12) + "ft" + " " + valleys%12 + "in";
        hips = Math.floor(hips/12) + "ft" + " " + hips%12 + "in";
        ridges = Math.floor(ridges/12) + "ft" + " " + ridges%12 + "in";
        rakes = Math.floor(rakes/12) + "ft" + " " + rakes%12 + "in";
        wall_flashing = Math.floor(wall_flashing/12) + "ft" + " " + wall_flashing%12 + "in";
        step_flahsing = Math.floor(step_flahsing/12) + "ft" + " " + step_flahsing%12 + "in";
        unspecified = Math.floor(unspecified/12) + "ft" + " " + unspecified%12 + "in";

        $('#eave').val(eaves + '');
        $('#valley').val(valleys + '');
        $('#hip').val(hips + '');
        $('#ridge').val(ridges + '');
        $('#rake').val(rakes + '');
        $('#wall_flashing').val(wall_flashing + '');
        $('#step_flahsing').val(step_flahsing + '');
        $('#unspecified').val(unspecified + '');

        var zero_twel = 0, one_twel = 0, two_twel = 0, three_twel = 0, four_twel = 0, five_twel = 0, six_twel = 0, seven_twel = 0, eight_twel = 0, nine_twel = 0, ten_twel = 0;
        var ele_twel = 0, twel_twel = 0, thirteen_twel = 0, fourteen_twel = 0, fifteen_twel = 0, sixteen_twel = 0, seventeen_twel = 0, eighteen_twel = 0, nineteen_twel = 0, twenty_twel = 0;
        var twentyone_twel = 0, twentytwo_twel = 0, twentythree_twel = 0, twentyfour_twel = 0, twentyfive_twel = 0, twentysix_twel = 0, twentyseven_twel = 0, twentyeight_twel = 0, twentynine_twel = 0, thirty_twel = 0;
        var thirtyone_twel = 0, thirtytwo_twel = 0, thirtythree_twel = 0, thirtyfour_twel = 0, thirtyfive_twel = 0, thirtysix_twel = 0, thirtyseven_twel = 0, thirtyeight_twel = 0, thirtynine_twel = 0, fourty_twel = 0;
        var fourtyone_twel = 0, fourtytwo_twel = 0, fourtythree_twel = 0, fourtyfour_twel = 0, fourtyfive_twel = 0, fourtysix_twel = 0, fourtyseven_twel = 0, fourtyeigth_twel = 0, fourtynine_twel = 0, fifty_twel = 0;
        var fiftyone_twel = 0, fiftytwo_twel = 0, fiftythree_twel = 0, fiftyfour_twel = 0, fiftyfive_twel = 0, fiftysix_twel = 0, fiftyseven_twel = 0, fiftyeight_twel = 0, fiftynine_twel = 0, sixty_twel = 0;
        var sixtyone_twel = 0, sixtytwo_twel = 0, sixtythree_twel = 0, sixtyfour_twel = 0, sixtyfive_twel = 0, sixtysix_twel = 0, sixtyseven_twel = 0, sixtyeight_twel = 0, sixtynine_twel = 0; seventy_twel = 0;
        var seventyone_twel = 0, seventytwo_twel = 0, seventythree_twel = 0, seventyfour_twel = 0, seventyfive_twel = 0, seventysix_twel = 0, seventyseven_twel = 0, seventyeight_twel = 0, seventynine_twel = 0, eighty_twel = 0;
        var eightyone_twel = 0, eightytwo_twel = 0, eightythree_twel = 0, eightyfour_twel = 0, eightyfive_twel = 0, eightysix_twel = 0, eightyseven_twel = 0, eightyeight_twel = 0, eightynine_twel = 0, ninety_twel = 0;
        var ninetyone_twel = 0, ninetytwo_twel = 0, ninetythree_twel = 0, ninetyfour_twel = 0, ninetyfive_twel = 0, ninetysix_twel = 0, ninetyseven_twel = 0, ninetyeight_twel = 0, ninetynine_twel = 0, hundred_twel = 0;
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
            } else if (layer1_polygon[i].pitch == 10) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            } else if (layer1_polygon[i].pitch == 11) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ele_twel += area;
            } else if (layer1_polygon[i].pitch == 12) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twel_twel += area;
            } else if (layer1_polygon[i].pitch == 13) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirteen_twel += area;
            } else if (layer1_polygon[i].pitch == 14) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourteen_twel += area;
            } else if (layer1_polygon[i].pitch == 15) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fifteen_twel += area;
            } else if (layer1_polygon[i].pitch == 16) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixteen_twel += area;
            } else if (layer1_polygon[i].pitch == 17) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventeen_twel += area;
            } else if (layer1_polygon[i].pitch == 18) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eighteen_twel += area;
            } else if (layer1_polygon[i].pitch == 19) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                nineteen_twel += area;
            } else if (layer1_polygon[i].pitch == 20) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twenty_twel += area;
            } else if (layer1_polygon[i].pitch == 21) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentyone_twel += area;
            } else if (layer1_polygon[i].pitch == 22) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 23) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentythree_twel += area;
            } else if (layer1_polygon[i].pitch == 24) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 25) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 26) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentysix_twel += area;
            } else if (layer1_polygon[i].pitch == 27) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 28) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 29) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                twentynine_twel += area;
            } else if (layer1_polygon[i].pitch == 30) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirty_twel += area;
            } else if (layer1_polygon[i].pitch == 31) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyone_twel += area;
            } else if (layer1_polygon[i].pitch == 32) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 33) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtythree_twel += area;
            } else if (layer1_polygon[i].pitch == 34) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 35) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 36) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtysix_twel += area;
            } else if (layer1_polygon[i].pitch == 37) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 38) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 39) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                thirtynine_twel += area;
            } else if (layer1_polygon[i].pitch == 40) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourty_twel += area;
            } else if (layer1_polygon[i].pitch == 41) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyone_twel += area;
            } else if (layer1_polygon[i].pitch == 42) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 43) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtythree_twel += area;
            } else if (layer1_polygon[i].pitch == 44) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 45) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 46) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtysix_twel += area;
            } else if (layer1_polygon[i].pitch == 47) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 48) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyeigth_twel += area;
            } else if (layer1_polygon[i].pitch == 49) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fourtynine_twel += area;
            } else if (layer1_polygon[i].pitch == 50) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fifty_twel += area;
            } else if (layer1_polygon[i].pitch == 51) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyone_twel += area;
            } else if (layer1_polygon[i].pitch == 52) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 53) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftythree_twel += area;
            } else if (layer1_polygon[i].pitch == 54) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 55) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 56) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftysix_twel += area;
            } else if (layer1_polygon[i].pitch == 57) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 58) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 59) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                fiftynine_twel += area;
            } else if (layer1_polygon[i].pitch == 60) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixty_twel += area;
            } else if (layer1_polygon[i].pitch == 61) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyone_twel += area;
            } else if (layer1_polygon[i].pitch == 62) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 63) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtythree_twel += area;
            } else if (layer1_polygon[i].pitch == 64) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 65) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 66) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtysix_twel += area;
            } else if (layer1_polygon[i].pitch == 67) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 68) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 69) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                sixtynine_twel += area;
            } else if (layer1_polygon[i].pitch == 70) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventy_twel += area;
            } else if (layer1_polygon[i].pitch == 71) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventyone_twel += area;
            } else if (layer1_polygon[i].pitch == 72) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 73) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventythree_twel += area;
            } else if (layer1_polygon[i].pitch == 74) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 75) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 76) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventysix_twel += area;
            } else if (layer1_polygon[i].pitch == 77) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 78) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 79) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                seventynine_twel += area;
            } else if (layer1_polygon[i].pitch == 80) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eighty_twel += area;
            } else if (layer1_polygon[i].pitch == 81) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightyone_twel += area;
            } else if (layer1_polygon[i].pitch == 82) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 83) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightythree_twel += area;
            } else if (layer1_polygon[i].pitch == 84) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 85) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 86) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightysix_twel += area;
            } else if (layer1_polygon[i].pitch == 87) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 88) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 89) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                eightynine_twel += area;
            } else if (layer1_polygon[i].pitch == 90) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninety_twel += area;
            } else if (layer1_polygon[i].pitch == 91) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyone_twel += area;
            } else if (layer1_polygon[i].pitch == 92) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetytwo_twel += area;
            } else if (layer1_polygon[i].pitch == 93) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetythree_twel += area;
            } else if (layer1_polygon[i].pitch == 94) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfour_twel += area;
            } else if (layer1_polygon[i].pitch == 95) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfive_twel += area;
            } else if (layer1_polygon[i].pitch == 96) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetysix_twel += area;
            } else if (layer1_polygon[i].pitch == 97) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyseven_twel += area;
            } else if (layer1_polygon[i].pitch == 98) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyeight_twel += area;
            } else if (layer1_polygon[i].pitch == 99) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                ninetynine_twel += area;
            } else if (layer1_polygon[i].pitch == 100) {
                var area = parseInt(mark1[i][mark1[i].length - 1].dragging._marker.options.icon.options.html);
                hundred_twel += area;
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
            } else if (layer2_polygon[i].pitch == 10) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            } else if (layer2_polygon[i].pitch == 11) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ele_twel += area;
            } else if (layer2_polygon[i].pitch == 12) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twel_twel += area;
            } else if (layer2_polygon[i].pitch == 13) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirteen_twel += area;
            } else if (layer2_polygon[i].pitch == 14) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourteen_twel += area;
            } else if (layer2_polygon[i].pitch == 15) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fifteen_twel += area;
            } else if (layer2_polygon[i].pitch == 16) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixteen_twel += area;
            } else if (layer2_polygon[i].pitch == 17) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventeen_twel += area;
            } else if (layer2_polygon[i].pitch == 18) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eighteen_twel += area;
            } else if (layer2_polygon[i].pitch == 19) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                nineteen_twel += area;
            } else if (layer2_polygon[i].pitch == 20) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twenty_twel += area;
            } else if (layer2_polygon[i].pitch == 21) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentyone_twel += area;
            } else if (layer2_polygon[i].pitch == 22) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 23) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentythree_twel += area;
            } else if (layer2_polygon[i].pitch == 24) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 25) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 26) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentysix_twel += area;
            } else if (layer2_polygon[i].pitch == 27) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 28) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 29) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                twentynine_twel += area;
            } else if (layer2_polygon[i].pitch == 30) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirty_twel += area;
            } else if (layer2_polygon[i].pitch == 31) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyone_twel += area;
            } else if (layer2_polygon[i].pitch == 32) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 33) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtythree_twel += area;
            } else if (layer2_polygon[i].pitch == 34) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 35) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 36) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtysix_twel += area;
            } else if (layer2_polygon[i].pitch == 37) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 38) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 39) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                thirtynine_twel += area;
            } else if (layer2_polygon[i].pitch == 40) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourty_twel += area;
            } else if (layer2_polygon[i].pitch == 41) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyone_twel += area;
            } else if (layer2_polygon[i].pitch == 42) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 43) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtythree_twel += area;
            } else if (layer2_polygon[i].pitch == 44) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 45) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 46) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtysix_twel += area;
            } else if (layer2_polygon[i].pitch == 47) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 48) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyeigth_twel += area;
            } else if (layer2_polygon[i].pitch == 49) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fourtynine_twel += area;
            } else if (layer2_polygon[i].pitch == 50) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fifty_twel += area;
            } else if (layer2_polygon[i].pitch == 51) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyone_twel += area;
            } else if (layer2_polygon[i].pitch == 52) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 53) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftythree_twel += area;
            } else if (layer2_polygon[i].pitch == 54) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 55) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 56) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftysix_twel += area;
            } else if (layer2_polygon[i].pitch == 57) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 58) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 59) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                fiftynine_twel += area;
            } else if (layer2_polygon[i].pitch == 60) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixty_twel += area;
            } else if (layer2_polygon[i].pitch == 61) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyone_twel += area;
            } else if (layer2_polygon[i].pitch == 62) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 63) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtythree_twel += area;
            } else if (layer2_polygon[i].pitch == 64) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 65) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 66) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtysix_twel += area;
            } else if (layer2_polygon[i].pitch == 67) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 68) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 69) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                sixtynine_twel += area;
            } else if (layer2_polygon[i].pitch == 70) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventy_twel += area;
            } else if (layer2_polygon[i].pitch == 71) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventyone_twel += area;
            } else if (layer2_polygon[i].pitch == 72) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 73) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventythree_twel += area;
            } else if (layer2_polygon[i].pitch == 74) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 75) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 76) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventysix_twel += area;
            } else if (layer2_polygon[i].pitch == 77) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 78) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 79) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                seventynine_twel += area;
            } else if (layer2_polygon[i].pitch == 80) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eighty_twel += area;
            } else if (layer2_polygon[i].pitch == 81) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightyone_twel += area;
            } else if (layer2_polygon[i].pitch == 82) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 83) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightythree_twel += area;
            } else if (layer2_polygon[i].pitch == 84) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 85) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 86) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightysix_twel += area;
            } else if (layer2_polygon[i].pitch == 87) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 88) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 89) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                eightynine_twel += area;
            } else if (layer2_polygon[i].pitch == 90) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninety_twel += area;
            } else if (layer2_polygon[i].pitch == 91) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyone_twel += area;
            } else if (layer2_polygon[i].pitch == 92) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetytwo_twel += area;
            } else if (layer2_polygon[i].pitch == 93) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetythree_twel += area;
            } else if (layer2_polygon[i].pitch == 94) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfour_twel += area;
            } else if (layer2_polygon[i].pitch == 95) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfive_twel += area;
            } else if (layer2_polygon[i].pitch == 96) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetysix_twel += area;
            } else if (layer2_polygon[i].pitch == 97) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyseven_twel += area;
            } else if (layer2_polygon[i].pitch == 98) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyeight_twel += area;
            } else if (layer2_polygon[i].pitch == 99) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                ninetynine_twel += area;
            } else if (layer2_polygon[i].pitch == 100) {
                var area = parseInt(mark2[i][mark2[i].length - 1].dragging._marker.options.icon.options.html);
                hundred_twel += area;
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
            } else if (layer3_polygon[i].pitch == 10) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            } else if (layer3_polygon[i].pitch == 11) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ele_twel += area;
            } else if (layer3_polygon[i].pitch == 12) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twel_twel += area;
            } else if (layer3_polygon[i].pitch == 13) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirteen_twel += area;
            } else if (layer3_polygon[i].pitch == 14) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourteen_twel += area;
            } else if (layer3_polygon[i].pitch == 15) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fifteen_twel += area;
            } else if (layer3_polygon[i].pitch == 16) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixteen_twel += area;
            } else if (layer3_polygon[i].pitch == 17) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventeen_twel += area;
            } else if (layer3_polygon[i].pitch == 18) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eighteen_twel += area;
            } else if (layer3_polygon[i].pitch == 19) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                nineteen_twel += area;
            } else if (layer3_polygon[i].pitch == 20) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twenty_twel += area;
            } else if (layer3_polygon[i].pitch == 21) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentyone_twel += area;
            } else if (layer3_polygon[i].pitch == 22) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 23) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentythree_twel += area;
            } else if (layer3_polygon[i].pitch == 24) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 25) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 26) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentysix_twel += area;
            } else if (layer3_polygon[i].pitch == 27) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 28) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 29) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                twentynine_twel += area;
            } else if (layer3_polygon[i].pitch == 30) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirty_twel += area;
            } else if (layer3_polygon[i].pitch == 31) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyone_twel += area;
            } else if (layer3_polygon[i].pitch == 32) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 33) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtythree_twel += area;
            } else if (layer3_polygon[i].pitch == 34) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 35) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 36) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtysix_twel += area;
            } else if (layer3_polygon[i].pitch == 37) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 38) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 39) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                thirtynine_twel += area;
            } else if (layer3_polygon[i].pitch == 40) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourty_twel += area;
            } else if (layer3_polygon[i].pitch == 41) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyone_twel += area;
            } else if (layer3_polygon[i].pitch == 42) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 43) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtythree_twel += area;
            } else if (layer3_polygon[i].pitch == 44) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 45) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 46) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtysix_twel += area;
            } else if (layer3_polygon[i].pitch == 47) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 48) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyeigth_twel += area;
            } else if (layer3_polygon[i].pitch == 49) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fourtynine_twel += area;
            } else if (layer3_polygon[i].pitch == 50) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fifty_twel += area;
            } else if (layer3_polygon[i].pitch == 51) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyone_twel += area;
            } else if (layer3_polygon[i].pitch == 52) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 53) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftythree_twel += area;
            } else if (layer3_polygon[i].pitch == 54) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 55) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 56) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftysix_twel += area;
            } else if (layer3_polygon[i].pitch == 57) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 58) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 59) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                fiftynine_twel += area;
            } else if (layer3_polygon[i].pitch == 60) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixty_twel += area;
            } else if (layer3_polygon[i].pitch == 61) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyone_twel += area;
            } else if (layer3_polygon[i].pitch == 62) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 63) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtythree_twel += area;
            } else if (layer3_polygon[i].pitch == 64) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 65) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 66) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtysix_twel += area;
            } else if (layer3_polygon[i].pitch == 67) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 68) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 69) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                sixtynine_twel += area;
            } else if (layer3_polygon[i].pitch == 70) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventy_twel += area;
            } else if (layer3_polygon[i].pitch == 71) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventyone_twel += area;
            } else if (layer3_polygon[i].pitch == 72) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 73) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventythree_twel += area;
            } else if (layer3_polygon[i].pitch == 74) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 75) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 76) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventysix_twel += area;
            } else if (layer3_polygon[i].pitch == 77) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 78) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 79) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                seventynine_twel += area;
            } else if (layer3_polygon[i].pitch == 80) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eighty_twel += area;
            } else if (layer3_polygon[i].pitch == 81) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightyone_twel += area;
            } else if (layer3_polygon[i].pitch == 82) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 83) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightythree_twel += area;
            } else if (layer3_polygon[i].pitch == 84) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 85) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 86) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightysix_twel += area;
            } else if (layer3_polygon[i].pitch == 87) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 88) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 89) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                eightynine_twel += area;
            } else if (layer3_polygon[i].pitch == 90) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninety_twel += area;
            } else if (layer3_polygon[i].pitch == 91) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyone_twel += area;
            } else if (layer3_polygon[i].pitch == 92) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetytwo_twel += area;
            } else if (layer3_polygon[i].pitch == 93) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetythree_twel += area;
            } else if (layer3_polygon[i].pitch == 94) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfour_twel += area;
            } else if (layer3_polygon[i].pitch == 95) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfive_twel += area;
            } else if (layer3_polygon[i].pitch == 96) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetysix_twel += area;
            } else if (layer3_polygon[i].pitch == 97) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyseven_twel += area;
            } else if (layer3_polygon[i].pitch == 98) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyeight_twel += area;
            } else if (layer3_polygon[i].pitch == 99) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                ninetynine_twel += area;
            } else if (layer3_polygon[i].pitch == 100) {
                var area = parseInt(mark3[i][mark3[i].length - 1].dragging._marker.options.icon.options.html);
                hundred_twel += area;
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
            } else if (layer4_polygon[i].pitch == 10) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            } else if (layer4_polygon[i].pitch == 11) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ele_twel += area;
            } else if (layer4_polygon[i].pitch == 12) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twel_twel += area;
            } else if (layer4_polygon[i].pitch == 13) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirteen_twel += area;
            } else if (layer4_polygon[i].pitch == 14) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourteen_twel += area;
            } else if (layer4_polygon[i].pitch == 15) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fifteen_twel += area;
            } else if (layer4_polygon[i].pitch == 16) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixteen_twel += area;
            } else if (layer4_polygon[i].pitch == 17) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventeen_twel += area;
            } else if (layer4_polygon[i].pitch == 18) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eighteen_twel += area;
            } else if (layer4_polygon[i].pitch == 19) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                nineteen_twel += area;
            } else if (layer4_polygon[i].pitch == 20) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twenty_twel += area;
            } else if (layer4_polygon[i].pitch == 21) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentyone_twel += area;
            } else if (layer4_polygon[i].pitch == 22) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 23) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentythree_twel += area;
            } else if (layer4_polygon[i].pitch == 24) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 25) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 26) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentysix_twel += area;
            } else if (layer4_polygon[i].pitch == 27) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 28) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 29) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                twentynine_twel += area;
            } else if (layer4_polygon[i].pitch == 30) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirty_twel += area;
            } else if (layer4_polygon[i].pitch == 31) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyone_twel += area;
            } else if (layer4_polygon[i].pitch == 32) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 33) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtythree_twel += area;
            } else if (layer4_polygon[i].pitch == 34) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 35) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 36) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtysix_twel += area;
            } else if (layer4_polygon[i].pitch == 37) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 38) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 39) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                thirtynine_twel += area;
            } else if (layer4_polygon[i].pitch == 40) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourty_twel += area;
            } else if (layer4_polygon[i].pitch == 41) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyone_twel += area;
            } else if (layer4_polygon[i].pitch == 42) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 43) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtythree_twel += area;
            } else if (layer4_polygon[i].pitch == 44) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 45) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 46) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtysix_twel += area;
            } else if (layer4_polygon[i].pitch == 47) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 48) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyeigth_twel += area;
            } else if (layer4_polygon[i].pitch == 49) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fourtynine_twel += area;
            } else if (layer4_polygon[i].pitch == 50) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fifty_twel += area;
            } else if (layer4_polygon[i].pitch == 51) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyone_twel += area;
            } else if (layer4_polygon[i].pitch == 52) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 53) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftythree_twel += area;
            } else if (layer4_polygon[i].pitch == 54) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 55) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 56) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftysix_twel += area;
            } else if (layer4_polygon[i].pitch == 57) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 58) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 59) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                fiftynine_twel += area;
            } else if (layer4_polygon[i].pitch == 60) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixty_twel += area;
            } else if (layer4_polygon[i].pitch == 61) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyone_twel += area;
            } else if (layer4_polygon[i].pitch == 62) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 63) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtythree_twel += area;
            } else if (layer4_polygon[i].pitch == 64) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 65) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 66) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtysix_twel += area;
            } else if (layer4_polygon[i].pitch == 67) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 68) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 69) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                sixtynine_twel += area;
            } else if (layer4_polygon[i].pitch == 70) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventy_twel += area;
            } else if (layer4_polygon[i].pitch == 71) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventyone_twel += area;
            } else if (layer4_polygon[i].pitch == 72) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 73) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventythree_twel += area;
            } else if (layer4_polygon[i].pitch == 74) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 75) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 76) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventysix_twel += area;
            } else if (layer4_polygon[i].pitch == 77) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 78) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 79) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                seventynine_twel += area;
            } else if (layer4_polygon[i].pitch == 80) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eighty_twel += area;
            } else if (layer4_polygon[i].pitch == 81) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightyone_twel += area;
            } else if (layer4_polygon[i].pitch == 82) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 83) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightythree_twel += area;
            } else if (layer4_polygon[i].pitch == 84) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 85) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 86) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightysix_twel += area;
            } else if (layer4_polygon[i].pitch == 87) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 88) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 89) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                eightynine_twel += area;
            } else if (layer4_polygon[i].pitch == 90) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninety_twel += area;
            } else if (layer4_polygon[i].pitch == 91) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyone_twel += area;
            } else if (layer4_polygon[i].pitch == 92) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetytwo_twel += area;
            } else if (layer4_polygon[i].pitch == 93) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetythree_twel += area;
            } else if (layer4_polygon[i].pitch == 94) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfour_twel += area;
            } else if (layer4_polygon[i].pitch == 95) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfive_twel += area;
            } else if (layer4_polygon[i].pitch == 96) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetysix_twel += area;
            } else if (layer4_polygon[i].pitch == 97) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyseven_twel += area;
            } else if (layer4_polygon[i].pitch == 98) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyeight_twel += area;
            } else if (layer4_polygon[i].pitch == 99) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                ninetynine_twel += area;
            } else if (layer4_polygon[i].pitch == 100) {
                var area = parseInt(mark4[i][mark4[i].length - 1].dragging._marker.options.icon.options.html);
                hundred_twel += area;
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
            } else if (layer5_polygon[i].pitch == 10) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ten_twel += area;
            } else if (layer5_polygon[i].pitch == 11) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ele_twel += area;
            } else if (layer5_polygon[i].pitch == 12) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twel_twel += area;
            } else if (layer5_polygon[i].pitch == 13) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirteen_twel += area;
            } else if (layer5_polygon[i].pitch == 14) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourteen_twel += area;
            } else if (layer5_polygon[i].pitch == 15) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fifteen_twel += area;
            } else if (layer5_polygon[i].pitch == 16) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixteen_twel += area;
            } else if (layer5_polygon[i].pitch == 17) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventeen_twel += area;
            } else if (layer5_polygon[i].pitch == 18) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eighteen_twel += area;
            } else if (layer5_polygon[i].pitch == 19) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                nineteen_twel += area;
            } else if (layer5_polygon[i].pitch == 20) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twenty_twel += area;
            } else if (layer5_polygon[i].pitch == 21) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentyone_twel += area;
            } else if (layer5_polygon[i].pitch == 22) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 23) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentythree_twel += area;
            } else if (layer5_polygon[i].pitch == 24) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 25) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 26) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentysix_twel += area;
            } else if (layer5_polygon[i].pitch == 27) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 28) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 29) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                twentynine_twel += area;
            } else if (layer5_polygon[i].pitch == 30) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirty_twel += area;
            } else if (layer5_polygon[i].pitch == 31) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyone_twel += area;
            } else if (layer5_polygon[i].pitch == 32) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 33) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtythree_twel += area;
            } else if (layer5_polygon[i].pitch == 34) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 35) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 36) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtysix_twel += area;
            } else if (layer5_polygon[i].pitch == 37) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 38) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 39) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                thirtynine_twel += area;
            } else if (layer5_polygon[i].pitch == 40) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourty_twel += area;
            } else if (layer5_polygon[i].pitch == 41) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyone_twel += area;
            } else if (layer5_polygon[i].pitch == 42) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 43) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtythree_twel += area;
            } else if (layer5_polygon[i].pitch == 44) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 45) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 46) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtysix_twel += area;
            } else if (layer5_polygon[i].pitch == 47) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 48) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtyeigth_twel += area;
            } else if (layer5_polygon[i].pitch == 49) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fourtynine_twel += area;
            } else if (layer5_polygon[i].pitch == 50) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fifty_twel += area;
            } else if (layer5_polygon[i].pitch == 51) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyone_twel += area;
            } else if (layer5_polygon[i].pitch == 52) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 53) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftythree_twel += area;
            } else if (layer5_polygon[i].pitch == 54) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 55) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 56) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftysix_twel += area;
            } else if (layer5_polygon[i].pitch == 57) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 58) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 59) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                fiftynine_twel += area;
            } else if (layer5_polygon[i].pitch == 60) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixty_twel += area;
            } else if (layer5_polygon[i].pitch == 61) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyone_twel += area;
            } else if (layer5_polygon[i].pitch == 62) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 63) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtythree_twel += area;
            } else if (layer5_polygon[i].pitch == 64) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 65) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 66) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtysix_twel += area;
            } else if (layer5_polygon[i].pitch == 67) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 68) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 69) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                sixtynine_twel += area;
            } else if (layer5_polygon[i].pitch == 70) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventy_twel += area;
            } else if (layer5_polygon[i].pitch == 71) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventyone_twel += area;
            } else if (layer5_polygon[i].pitch == 72) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 73) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventythree_twel += area;
            } else if (layer5_polygon[i].pitch == 74) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 75) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 76) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventysix_twel += area;
            } else if (layer5_polygon[i].pitch == 77) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 78) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 79) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                seventynine_twel += area;
            } else if (layer5_polygon[i].pitch == 80) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eighty_twel += area;
            } else if (layer5_polygon[i].pitch == 81) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightyone_twel += area;
            } else if (layer5_polygon[i].pitch == 82) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 83) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightythree_twel += area;
            } else if (layer5_polygon[i].pitch == 84) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 85) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 86) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightysix_twel += area;
            } else if (layer5_polygon[i].pitch == 87) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 88) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 89) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                eightynine_twel += area;
            } else if (layer5_polygon[i].pitch == 90) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninety_twel += area;
            } else if (layer5_polygon[i].pitch == 91) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyone_twel += area;
            } else if (layer5_polygon[i].pitch == 92) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetytwo_twel += area;
            } else if (layer5_polygon[i].pitch == 93) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetythree_twel += area;
            } else if (layer5_polygon[i].pitch == 94) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfour_twel += area;
            } else if (layer5_polygon[i].pitch == 95) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyfive_twel += area;
            } else if (layer5_polygon[i].pitch == 96) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetysix_twel += area;
            } else if (layer5_polygon[i].pitch == 97) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyseven_twel += area;
            } else if (layer5_polygon[i].pitch == 98) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetyeight_twel += area;
            } else if (layer5_polygon[i].pitch == 99) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                ninetynine_twel += area;
            } else if (layer5_polygon[i].pitch == 100) {
                var area = parseInt(mark5[i][mark5[i].length - 1].dragging._marker.options.icon.options.html);
                hundred_twel += area;
            }
        }

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
        $('#ele_twel').val(ele_twel + '');
        $('#twel_twel').val(twel_twel + '');
        $('#thirteen_twel').val(thirteen_twel + '');
        $('#fourteen_twel').val(fourteen_twel + '');
        $('#fifteen_twel').val(fifteen_twel + '');
        $('#sixteen_twel').val(sixteen_twel + '');
        $('#seventeen_twel').val(seventeen_twel + '');
        $('#eighteen_twel').val(eighteen_twel + '');
        $('#nineteen_twel').val(nineteen_twel + '');
        $('#twenty_twel').val(twenty_twel + '');
        $('#twentyone_twel').val(twentyone_twel + '');
        $('#twentytwo_twel').val(twentytwo_twel + '');
        $('#twentythree_twel').val(twentythree_twel + '');
        $('#twentyfour_twel').val(twentyfour_twel + '');
        $('#twentyfive_twel').val(twentyfive_twel + '');
        $('#twentysix_twel').val(twentysix_twel + '');
        $('#twentyseven_twel').val(twentyseven_twel + '');
        $('#twentyeight_twel').val(twentyeight_twel + '');
        $('#twentynine_twel').val(twentynine_twel + '');
        $('#thirty_twel').val(thirty_twel + '');
        $('#thirtyone_twel').val(thirtyone_twel + '');
        $('#thirtytwo_twel').val(thirtytwo_twel + '');
        $('#thirtythree_twel').val(thirtythree_twel + '');
        $('#thirtyfour_twel').val(thirtyfour_twel + '');
        $('#thirtyfive_twel').val(thirtyfive_twel + '');
        $('#thirtysix_twel').val(thirtysix_twel + '');
        $('#thirtyseven_twel').val(thirtyseven_twel + '');
        $('#thirtyeight_twel').val(thirtyeight_twel + '');
        $('#thirtynine_twel').val(thirtynine_twel + '');
        $('#fourty_twel').val(fourty_twel + '');
        $('#fourtyone_twel').val(fourtyone_twel + '');
        $('#fourtytwo_twel').val(fourtytwo_twel + '');
        $('#fourtythree_twel').val(fourtythree_twel + '');
        $('#fourtyfour_twel').val(fourtyfour_twel + '');
        $('#fourtyfive_twel').val(fourtyfive_twel + '');
        $('#fourtysix_twel').val(fourtysix_twel + '');
        $('#fourtyseven_twel').val(fourtyseven_twel + '');
        $('#fourtyeigth_twel').val(fourtyeigth_twel + '');
        $('#fourtynine_twel').val(fourtynine_twel + '');
        $('#fifty_twel').val(fifty_twel + '');
        $('#fiftyone_twel').val(fiftyone_twel + '');
        $('#fiftytwo_twel').val(fiftytwo_twel + '');
        $('#fiftythree_twel').val(fiftythree_twel + '');
        $('#fiftyfour_twel').val(fiftyfour_twel + '');
        $('#fiftyfive_twel').val(fiftyfive_twel + '');
        $('#fiftysix_twel').val(fiftysix_twel + '');
        $('#fiftyseven_twel').val(fiftyseven_twel + '');
        $('#fiftyeight_twel').val(fiftyeight_twel + '');
        $('#fiftynine_twel').val(fiftynine_twel + '');
        $('#sixty_twel').val(sixty_twel + '');
        $('#sixtyone_twel').val(sixtyone_twel + '');
        $('#sixtytwo_twel').val(sixtytwo_twel + '');
        $('#sixtythree_twel').val(sixtythree_twel + '');
        $('#sixtyfour_twel').val(sixtyfour_twel + '');
        $('#sixtyfive_twel').val(sixtyfive_twel + '');
        $('#sixtysix_twel').val(sixtysix_twel + '');
        $('#sixtyseven_twel').val(sixtyseven_twel + '');
        $('#sixtyeight_twel').val(sixtyeight_twel + '');
        $('#sixtynine_twel').val(sixtynine_twel + '');
        $('#seventy_twel').val(seventy_twel + '');
        $('#seventyone_twel').val(seventyone_twel + '');
        $('#seventytwo_twel').val(seventytwo_twel + '');
        $('#seventythree_twel').val(seventythree_twel + '');
        $('#seventyfour_twel').val(seventyfour_twel + '');
        $('#seventyfive_twel').val(seventyfive_twel + '');
        $('#seventysix_twel').val(seventysix_twel + '');
        $('#seventyseven_twel').val(seventyseven_twel + '');
        $('#seventyeight_twel').val(seventyeight_twel + '');
        $('#seventynine_twel').val(seventynine_twel + '');
        $('#eighty_twel').val(eighty_twel + '');
        $('#eightyone_twel').val(eightyone_twel + '');
        $('#eightytwo_twel').val(eightytwo_twel + '');
        $('#eightythree_twel').val(eightythree_twel + '');
        $('#eightyfour_twel').val(eightyfour_twel + '');
        $('#eightyfive_twel').val(eightyfive_twel + '');
        $('#eightysix_twel').val(eightysix_twel + '');
        $('#eightyseven_twel').val(eightyseven_twel + '');
        $('#eightyeight_twel').val(eightyeight_twel + '');
        $('#eightynine_twel').val(eightynine_twel + '');
        $('#ninety_twel').val(ninety_twel + '');
        $('#ninetyone_twel').val(ninetyone_twel + '');
        $('#ninetytwo_twel').val(ninetytwo_twel + '');
        $('#ninetythree_twel').val(ninetythree_twel + '');
        $('#ninetyfour_twel').val(ninetyfour_twel + '');
        $('#ninetyfive_twel').val(ninetyfive_twel + '');
        $('#ninetysix_twel').val(ninetysix_twel + '');
        $('#ninetyseven_twel').val(ninetyseven_twel + '');
        $('#ninetyeight_twel').val(ninetyeight_twel + '');
        $('#ninetynine_twel').val(ninetynine_twel + '');
        $('#hundred_twel').val(hundred_twel + '');

        $('#type').val('csv');
        $('#real-address').val('{{$address}}');
        $('#total-area').val(totalArea + '');
        $("#download_form").submit();
    };

    function downloadPDF() {
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

        var eaves = 0, valleys = 0, hips = 0, ridges = 0, rakes = 0, wall_flashing = 0, step_flahsing = 0, unspecified = 0;

        for (var i = 0; i < layer1_lines.length; i ++) {
            if (layer1_lines[i].type == "Eaves") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer1_lines[i].type == "Valleys") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer1_lines[i].type == "Hips") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer1_lines[i].type == "Ridges") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer1_lines[i].type == "Rakes") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer1_lines[i].type == "Wall_Flashing") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer1_lines[i].type == "Step_Flashing") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer1_lines[i].type == "Unspecified") {
                var original_length = layer1_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer2_lines.length; i ++) {
            if (layer2_lines[i].type == "Eaves") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer2_lines[i].type == "Valleys") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer2_lines[i].type == "Hips") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer2_lines[i].type == "Ridges") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer2_lines[i].type == "Rakes") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer2_lines[i].type == "Wall_Flashing") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer2_lines[i].type == "Step_Flashing") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer2_lines[i].type == "Unspecified") {
                var original_length = layer2_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer3_lines.length; i ++) {
            if (layer3_lines[i].type == "Eaves") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer3_lines[i].type == "Valleys") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer3_lines[i].type == "Hips") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer3_lines[i].type == "Ridges") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer3_lines[i].type == "Rakes") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer3_lines[i].type == "Wall_Flashing") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer3_lines[i].type == "Step_Flashing") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer3_lines[i].type == "Unspecified") {
                var original_length = layer3_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer4_lines.length; i ++) {
            if (layer4_lines[i].type == "Eaves") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer4_lines[i].type == "Valleys") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer4_lines[i].type == "Hips") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer4_lines[i].type == "Ridges") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer4_lines[i].type == "Rakes") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer4_lines[i].type == "Wall_Flashing") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer4_lines[i].type == "Step_Flashing") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer4_lines[i].type == "Unspecified") {
                var original_length = layer4_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        for (var i = 0; i < layer5_lines.length; i ++) {
            if (layer5_lines[i].type == "Eaves") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                eaves += original_length;
            } else if (layer5_lines[i].type == "Valleys") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                valleys += original_length;

            } else if (layer5_lines[i].type == "Hips") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                hips += original_length;
                
            } else if (layer5_lines[i].type == "Ridges") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                ridges += original_length;
                
            } else if (layer5_lines[i].type == "Rakes") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                rakes += original_length;
                
            } else if (layer5_lines[i].type == "Wall_Flashing") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                wall_flashing += original_length;
                
            } else if (layer5_lines[i].type == "Step_Flashing") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                step_flahsing += original_length;
                
            } else if (layer5_lines[i].type == "Unspecified") {
                var original_length = layer5_lines[i].length;
                original_length = original_length.split(" ");
                if (original_length.length > 1)
                    original_length = parseInt(original_length[0])*12 + parseInt(original_length[1]);
                else
                    original_length = parseInt(original_length[0])*12;

                unspecified += original_length;
            }
        }

        eaves = Math.floor(eaves/12) + "ft" + " " + eaves%12 + "in";
        valleys = Math.floor(valleys/12) + "ft" + " " + valleys%12 + "in";
        hips = Math.floor(hips/12) + "ft" + " " + hips%12 + "in";
        ridges = Math.floor(ridges/12) + "ft" + " " + ridges%12 + "in";
        rakes = Math.floor(rakes/12) + "ft" + " " + rakes%12 + "in";
        wall_flashing = Math.floor(wall_flashing/12) + "ft" + " " + wall_flashing%12 + "in";
        step_flahsing = Math.floor(step_flahsing/12) + "ft" + " " + step_flahsing%12 + "in";
        unspecified = Math.floor(unspecified/12) + "ft" + " " + unspecified%12 + "in";

        $('#eave').val(eaves + '');
        $('#valley').val(valleys + '');
        $('#hip').val(hips + '');
        $('#ridge').val(ridges + '');
        $('#rake').val(rakes + '');
        $('#wall_flashing').val(wall_flashing + '');
        $('#step_flahsing').val(step_flahsing + '');
        $('#unspecified').val(unspecified + '');

        $('#type').val('pdf');
        $('#real-address').val('{{$address}}');
        $('#total-area').val(totalArea + '');
        $("#download_form").submit();
    }

    // function hideToolbar() {
    //     $('#right_tool_bar').removeClass("normal");
    //     $('#right_tool_bar').addClass("grow");

    //     $('#right').addClass('hidden');
    //     $('#left').removeClass('hidden');
    //     $('#left').css({
    //         'margin-top' : '0px'
    //     });

    //     $('span[id*=tool-name]').addClass('hidden');
    //     $('div[id=name]').addClass('hidden');
    //     $('#normal_draw').addClass('hide-tool');
    //     $('#move_anchor').addClass('hide-tool');
    // }

    // function showToolbar() {
    //     $('#right_tool_bar').addClass("normal");
    //     $('#right_tool_bar').removeClass("grow");

    //     $('#right').removeClass('hidden');
    //     $('#left').addClass('hidden');
    //     $('#left').css({
    //         'margin-top' : '13px'
    //     });

    //     $('span[id*=tool-name]').removeClass('hidden');
    //     $('div[id=name]').removeClass('hidden');
    //     $('#normal_draw').removeClass('hide-tool');
    //     $('#move_anchor').removeClass('hide-tool');
    // }

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
                layer1_polygon[l].editing.disable();
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
                    temp_label1 = [];
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
                layer2_polygon[l].editing.disable();
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
                    temp_label2 = [];
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
                layer3_polygon[l].editing.disable();
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
                    temp_label3 = [];
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
                layer4_polygon[l].editing.disable();
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
                    temp_label4 = [];
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
                layer5_polygon[l].editing.disable();
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
                    temp_label5 = [];
                }
            }
        }

        $('.edges').addClass('hidden');
        $('#right_tool_bar').removeClass('hidden');
        $('.facets').addClass('hidden');
    });

    $('#edge-tab').click(function() {
        myPolylineDrawHandler.disable();
        disableMoveAnchor();
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
                    temp_label1 = [];
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
                    temp_label2 = [];
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
                    temp_label3 = [];
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
                    temp_label4 = [];
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
                    temp_label5 = [];
                }
            }
        }

        $('#right_tool_bar').addClass('hidden');
        $('.edges').removeClass('hidden');
        $('.facets').addClass('hidden');
    });

    $('#facet-tab').click(function() {
        myPolylineDrawHandler.disable();
        disableMoveAnchor();
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
                    temp_label1 = [];
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
                    temp_label2 = [];
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
                    temp_label3 = [];
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
                    temp_label4 = [];
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
                    temp_label5 = [];
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
        window.open(
            'https://www.google.com/maps/@?api=1&map_action=map&zoom=20&basemap=satellite&center={{$lat}},{{$lng}}',
            '_blank' // <- This is what makes it open in a new window.
        );
        // window.location.href = 'https://www.google.com/maps/@?api=1&map_action=map&zoom=20&basemap=satellite&center={{$lat}},{{$lng}}';
    });

    $('#normal_draw').click(function() {
        myPolylineDrawHandler.enable();
        disableMoveAnchor();
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
        myPolylineDrawHandler.disable();
        deleteAllEdge();
        if (la1_isClick) {
            for (var i = 0; i < layer1_polygon.length; i ++) {
                var polygon = layer1_polygon[i];
                if (polygon.labelMarkers == undefined)
                    polygon.labelMarkers = [];

                if (polygon.templabelMarkers == undefined)
                    polygon.templabelMarkers = [];

                polygon.setStyle({fillColor: 'transparent'});
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

                polygon.setStyle({fillColor: 'transparent'});
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

                polygon.setStyle({fillColor: 'transparent'});
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
                polygon.setStyle({fillColor: 'transparent'});
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
                polygon.setStyle({fillColor: 'transparent'});
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

    function disableMoveAnchor() {
        for (var i = 0; i < layer1_polygon.length; i ++) {
            layer1_polygon[i].editing.disable();
        }

        for (var i = 0; i < layer2_polygon.length; i ++) {
            layer2_polygon[i].editing.disable();
        }

        for (var i = 0; i < layer3_polygon.length; i ++) {
            layer3_polygon[i].editing.disable();
        }

        for (var i = 0; i < layer4_polygon.length; i ++) {
            layer4_polygon[i].editing.disable();
        }

        for (var i = 0; i < layer5_polygon.length; i ++) {
            layer5_polygon[i].editing.disable();
        }
    }

    $('#upload_img').click(function() {
        myPolylineDrawHandler.disable();
        disableMoveAnchor();
        if (firstModal.style.display == "block" || setInchModal.style.display == "block" || deleteModal.style.display == "block") {
            alert("Close All Before Window");
            return false;
        } else {
            uploadModal.style.display = "block";
        }
    });

    $('#reset_scale').click(function() {
        myPolylineDrawHandler.disable();
        disableMoveAnchor();
        if (firstModal.style.display == "block" || uploadModal.style.display == "block" || setInchModal.style.display == "block" || deleteModal.style.display == "block") {
            alert("Close All Before Window");
            return false;
        } else {
            resetClicked = true;
            firstModal.style.display = "block";
        }
    })

    function deleteAllEdges() {
        myPolylineDrawHandler.disable();
        disableMoveAnchor();
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
        $("#totalArea").text(0);
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
            maxZoom: 1,
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer1.length - 1;
                for (var i = 0; i < layer1_lines.length; i ++) {
                    polyline = layer1_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer1[count].length - 1; j ++) {
                    polyline = L.polyline([layer1[count][j], layer1[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    // map.on('almost:over', function (e) {
                    //     $(".leaflet-mouse-marker").css ({
                    //         'cursor': 'copy'
                    //     });
                    // });
                    // map.on('almost:out', function(e) {
                    //     crosshair();
                    // });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark1[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark1[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        // map.on('almost:over', function (e) {
                        //     $('html,body').css('cursor','crosshair');
                        // });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark1[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark1[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer2.length - 1;
                for (var i = 0; i < layer2_lines.length; i ++) {
                    polyline = layer2_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer2[count].length - 1; j ++) {
                    polyline = L.polyline([layer2[count][j], layer2[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark2[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark2[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark2[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark2[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer3.length - 1;
                for (var i = 0; i < layer3_lines.length; i ++) {
                    polyline = layer3_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer3[count].length - 1; j ++) {
                    polyline = L.polyline([layer3[count][j], layer3[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark3[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark3[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark3[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark3[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer4.length - 1;
                for (var i = 0; i < layer4_lines.length; i ++) {
                    polyline = layer4_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer4[count].length - 1; j ++) {
                    polyline = L.polyline([layer4[count][j], layer4[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark4[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark4[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark4[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark4[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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

                $("#totalArea").text(Number($("#totalArea").text()) + polygonArea);

                var polyline = null;
                var count = layer5.length - 1;
                for (var i = 0; i < layer5_lines.length; i ++) {
                    polyline = layer5_lines[i].addTo(map);
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            }
                        }
                    });
                }
                for (var j = 0; j < layer5[count].length - 1; j ++) {
                    polyline = L.polyline([layer5[count][j], layer5[count][j + 1]], {color: '#3388ff', opacity: 1, weight: 2}).addTo(map);
                    map.almostOver.addLayer(polyline);
                    map.on('almost:click', function(e) {
                        var layer = e.layer;
                        if (layer.openPopup) {
                            layer.fire('click', e);
                        }
                    });
                    polyline.pgindex = count;
                    polyline.index = j;
                    polyline.status = 1;
                    polyline.color = '#3388ff';
                    polyline.length = mark5[polyline.pgindex][polyline.index].editing._marker.options.icon.options.html;
                    polyline.type = "Unspecified";
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
                                e.target.type = lineType;
                                e.target.color = lineColor;
                                e.target.setStyle({
                                    color: lineColor
                                });
                                deleteEdgeStatus = false;
                            } else {
                                var original_length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
                                original_length = original_length.split(" ");
                                if (original_length.length > 1)
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
                                e.target.type = lineType;
                                e.target.length = mark5[e.target.pgindex][e.target.index].editing._marker.options.icon.options.html;
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
                        map.almostOver.addLayer(polyline);
                        map.on('almost:click', function(e) {
                            var layer = e.layer;
                            if (layer.openPopup) {
                                layer.fire('click', e);
                            }
                        });
                        polyline.pgindex = count;
                        polyline.index = j;
                        polyline.status = 1;
                        polyline.color = '#3388ff';
                        polyline.length = mark5[polyline.pgindex][polyline.index + 1].editing._marker.options.icon.options.html;
                        polyline.type = "Unspecified";
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
                                    e.target.type = lineType;
                                    e.target.color = lineColor;
                                    e.target.setStyle({
                                        color: lineColor
                                    });
                                    deleteEdgeStatus = false;
                                } else {
                                    var original_length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
                                    original_length = original_length.split(" ");
                                    if (original_length.length > 1)
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

                                    e.target.type = lineType;
                                    e.target.length = mark5[e.target.pgindex][e.target.index + 1].editing._marker.options.icon.options.html;
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
