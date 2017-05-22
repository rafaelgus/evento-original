<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Evento Original</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico">
@yield('scripts_head')

<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/backend/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/backend/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
{{--<!-- AdminLTE Skins. Choose a skin from the css/skins--}}
{{--folder instead of downloading all of them to reduce the load. -->--}}
{{--<link rel="stylesheet" href="{{ template_path('dist/css/skins/_all-skins.min.css') }}">--}}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@if(Auth::check())
    @include('backend.partials.header')
    @include('backend.partials.sidebar')
@endif

<!-- Content Wrapper. Contains page content -->
    @if(!Auth::check())
        <div class="content-wrapper" style="min-height: 339px;margin-left: 0px;">
            @yield('header')
            @yield('content')
        </div>
    @endif

    @if(Auth::check())
        <div class="content-wrapper">
            @yield('header')
            @yield('content')
        </div>
@endif

@if(Auth::check())
    @include('backend.partials.footer')
@endif

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>

<!------------------------- REQUIRED JS SCRIPTS------------------------->
<!-- jQuery 2.1.4 -->
<script src="/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/backend/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/backend/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="/backend/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="backend/js/demo.js"></script>
<script src="/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>

@yield('scripts_body')

</body>
