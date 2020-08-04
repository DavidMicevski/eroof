<header class="main-header">
  <a href="#" class="logo">
    <img src="{{ asset("/bower_components/AdminLTE/dist/img/icon.png") }}">
    <p class="user-info">
      {{ Auth::user()->email}}
    </p>
  </a>
  <nav class="navbar navbar-static-top" role="navigation">
    @if (Request::path() == 'map/create')
      <div class="col-md-2 title" style="color: #fff; float: left;">
        Create new proposal
      </div>
      <div class="col-md-1" style="float: right; padding-right: 0; margin-right: 15px">
        <a class="btn btn-primary purchase" id="confirm_image" style="width: 100%; margin-right: 0">CONFIRM IMAGE</a>
      </div>
    @endif
    @if (Request::path() == 'map/upload')
      <a href="{{ route('map.create') }}" style="float: left;"><i class="fa fa-angle-left direct-back"></i></a>
      <div class="col-md-offset-5 col-md-3 title">
        Select Image
      </div>
    @endif
    @if (Request::path() == 'map')
      <a class="btn btn-primary purchase" href="{{ route('map.create') }}">Purchase More Images</a>
      <span style="float: right; color: #fff">Premium Credits Remaining: 2</span>
    @endif
    @if (Request::path() == 'map/real')
      <button id="draw-tab" class="tabs" style="color: #fff">Draw</button>
      <button id="edge-tab" class="tabs" style="color: #fff">Edges</button>
      <button id="facet-tab" class="tabs" style="color: #fff">Facets</button>
      <div class="col-md-1" style="float: right; padding-right: 0; margin-right: 15px">
        <a class="btn btn-primary purchase" id="pitch_btn" style="width: 100%; margin-right: 0">ViewPitch</a>
      </div>
      <div class="col-md-1" style="float: right;">
        <a class="btn btn-primary purchase" id="google_btn" style="width: 100%; margin-right: 0">GoogleMap</a>
      </div>
      <div class="col-md-1" style="float: right;">
        <div class="custom-select">
          <select id="download-type" onchange="downloadType()">
            <option value="0">Download</option>
            <option value="1">Download PDF</option>
            <option value="2">Download CSV</option>
            <option value="3">Send Email</option>
          </select>
        </div>
      </div>
      <div class="col-md-offset-3 col-md-2" id="address" style="padding-top: 20px; color: #fff; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
      </div>
    @endif
  </nav>
</header>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var height = $('.main-header').height();
    $(".tabs").css({
      'height' : height - 1,
      'width' : height
    });

    $('#undo-redo').height(height - 1);
  });
</script>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  {{ csrf_field() }}
</form>