<html>
  <head>
    <meta charset="utf-8">
    <title>RoofRuler Pitch Tool</title>
    <link rel="shortcut icon" href="{{ asset("/bower_components/AdminLTE/dist/img/icon.png") }}" type="image/x-icon"/>
    <script src="https://browser.sentry-cdn.com/5.4.0/bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&v=3.exp&signed_in=true"></script>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px;
        font-family: Helvetica;
      }

      .error {
        text-align: center;
        margin-top: 50px;
      }

      #guage {
        position: absolute;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        top: 50%;
        max-width: 100%;
        max-height: 100%;
        z-index: 2;
        pointer-events: none;
      }

      #wrapper #guage, #wrapper #map-canvas {
        display: none;
      }
      .loaded #wrapper #guage, 
      .loaded #wrapper #panel, 
      .loaded #wrapper #map-canvas {
        display: block;
      }

    </style>
    <script>
      var panorama;
      var params = getUrlVars();
      
      Sentry.init({ dsn: 'https://8409a7fc12f04ec4bde2cf72f9787497@sentry.io/1478139' });

      function getUrlVars() {
          var vars = {};
          var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
              vars[key] = value;
          });
          return vars;
      }

      function initialize() {
        if ("{{$lat}}" == undefined || "{{$lng}}" == undefined) {
          throw new Error('No location found! Please contact support@roofr.com');
        }        

        // Set up the map
        var mapOptions = {
          streetViewControl: false,
          addressControl: false,
          linksControl: false,
          panControl: false,
          enableCloseButton: false
        };

        var place = new google.maps.LatLng("{{$lat}}", "{{$lng}}");

        var panorama = new google.maps.StreetViewPanorama(document.getElementById('map-canvas'), mapOptions);
        panorama.setPosition(place);

        show();
      }

      function show(error) {
        // Error has occurred
        if (error) {
          var body = document.getElementsByTagName("body")[0];
          var errorDiv = document.querySelectorAll('.error')[0];
          errorDiv.innerText = error;
          return body.classList.add('error');
        }

        // Toggle the shower!
        var body = document.getElementsByTagName("body")[0];
        body.classList.add('loaded');
      }

      google.maps.event.addDomListener(window, 'load', function() {
        try {
          initialize();
        } catch (err) {
          show(err.message)
          Sentry.captureException(err);
        }
      }); // Initialize google
    </script>
  </head>
  
  <body>
    <div id="wrapper">
      <img id="guage" src="{{ asset('/bower_components/AdminLTE/dist/img/pitch-gauge.png') }}" />
      <div id="map-canvas"></div>
      <h2 class="error"></div>
    </div>
  </body>
</html>