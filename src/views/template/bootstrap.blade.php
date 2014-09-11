<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        @yield("head","Human Mobility - IBM Research | Africa")

    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

{{--@todo create a gulp task to minify all this and have a more optimized css head--}}
    <!-- Loading Bootstrap -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/hm/css/flat-ui.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.ico">
    <link href="/bower_components/leaflet/dist/leaflet.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/hm/css/maps-fix.css"/>
    <link rel="stylesheet" href="/app/css/main.css" />
    <style>
        .headroom {position: fixed;top: 0;left: 0;right: 0;transition: all .2s ease-in-out;}
        .headroom--unpinned {top: -100px;}
        .headroom--pinned {top: 0;}
    </style>

    @yield('styles')


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
        <div class='container'>
            The Living Road Network (Nairobi, Kenya)
        </div>
    </div>
</div>

<div class="container">
        @yield("body")
</div>





<!-- Load JS here for greater good =============================-->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/hm/app/request-animation-polyfill.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/hm/js/flatui-checkbox.js"></script>
<script src="/hm/js/flatui-radio.js"></script>
<script src="/hm/js/jquery.tagsinput.js"></script>
<script src="/hm/js/jquery.placeholder.js"></script>
<script src="/bower_components/headroom.js/dist/headroom.js"></script>
<script src="/bower_components/headroom.js/dist/jQuery.headroom.js"></script>
<script>
$(".navbar").headroom();

</script>

@yield('scripts')





</body>
</html>