<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>hfow</title>
    <link rel="shortcut icon" href="{{"panel/assets/media/image/favicon.png"}}">
    <meta name="theme-color" content="#5867dd">
    <link rel="stylesheet" href="{{url("panel/vendors/bundle.css")}}" type="text/css">
    <link rel="stylesheet" href="{{url("panel/vendors/slick/slick.css")}}">
    <link rel="stylesheet" href="{{url("panel/vendors/slick/slick-theme.css")}}">
    <link rel="stylesheet" href="{{url("panel/vendors/vmap/jqvmap.min.css")}}">
    <link rel="stylesheet" href="{{url('Panel/plugins/sweet_alert/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{url("panel/assets/css/app.css")}}" type="text/css">
    @livewireStyles
</head>
<body class="small-navigation">
@include("dashboard::components.layouts.navigation")<!-- end::navigation -->
<!-- begin::header -->
@include('dashboard::components.layouts.header')<!-- end::header -->
<!-- begin::main content -->
{{$slot}}
<script src="{{url("panel/vendors/bundle.js")}}"></script>
<script src="{{url("panel/vendors/slick/slick.min.js")}}"></script>
<script src="{{url("panel/vendors/vmap/jquery.vmap.min.js")}}"></script>
<script src="{{url("panel/assets/js/app.js")}}"></script>
<script src="{{ url('Panel/plugins/sweet_alert/sweetalert2.all.min.js') }}"></script>
@livewireScripts
@stack('scripts')

</body>
</html>
