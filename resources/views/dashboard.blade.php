<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Roof Ruler</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="{{ asset("/bower_components/AdminLTE/dist/img/icon.png") }}" type="image/x-icon"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css")}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/app-template.css') }}" rel="stylesheet">
  <link href="{{ asset('css/ui.css') }}" rel="stylesheet">
  <link href="{{ asset('css/leaflet.css') }}" rel="stylesheet">
  <link href="{{ asset('css/leaflet.draw.css') }}" rel="stylesheet">
  <link href="{{ asset('css/L.Grid.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  @include('layouts.header')
  @include('layouts.sidebar')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <section class="content">
    </section>
  </div>
<script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
</body>
</html>
