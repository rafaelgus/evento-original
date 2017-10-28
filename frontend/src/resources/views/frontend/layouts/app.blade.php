<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Evento Original</title>

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">

    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS Style -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/simple-line-icons.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.bxslider.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.mobile-menu.css">
    <link rel="stylesheet" type="text/css" href="/css/revslider.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/checkout.css" >
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,500,700,800' rel='stylesheet'
          type='text/css'>

    @yield('scripts_header')
</head>

<body class="cms-index-index cms-home-page">
<div id="page">
    @include('frontend.partials.header')

    @yield('content')
</div>

@include('frontend.partials.newsletter')

@include('frontend.partials.footer')

@include('frontend.partials.mobile-menu')

@include('frontend.partials.scripts')

@yield('scripts_body')

<script>
    cartItems();

    function cartItems() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/cartItems', true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                var cartItems = JSON.parse(xhr.responseText);

                if(cartItems['itemQuantity'] > 0) {
                    document.getElementById('cartQty').textContent = cartItems['itemQuantity'];
                } else {
                    document.getElementById('cartQty').textContent = '{{ trans('frontend/shopping_cart.empty') }}';
                }

            }
        };
        xhr.send();
    }

</script>

</body>
</html>
