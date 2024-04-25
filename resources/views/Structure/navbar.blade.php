<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Roiyall Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Website Template by freehtml5.co" />
    <meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="freehtml5.co" />

    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i,500,600i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <!-- Flexslider  -->
    <link rel="stylesheet" href="{{ asset('css/flexslider.css') }}">

    <!-- Theme style  -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Modernizr JS -->
    <script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
    <!-- FOR IE9 below -->
    <!-- [if lt IE 9]> -->
    <!-- <script src="js/respond.min.js"></script> -->
    <!-- <![endif]-->
    <style>
        .fh5co-nav ul li a:hover {
            color: #ff6600;
            /* Ganti warna sesuai kebutuhan */
        }
    </style>

</head>

<body>

    <div class="fh5co-loader"></div>

    <div id="page">
        <nav class="fh5co-nav" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center logo-wrap">
                        <div id="fh5co-logo"><a href="{{ route('home') }}">Roiyall Coffee<span>.</span></a></div>
                    </div>
                    <div class="col-xs-12 text-center menu-1 menu-wrap">
                        <ul>
                            <li class="active"><a href="{{ route('home') }}">Home</a></li>
                            <li class="has-dropdown">
                                <a href="gallery.html">Menu</a>
                                <ul class="dropdown">
                                    <li><a href="#">Events</a></li>
                                    <li><a href="#">Food</a></li>
                                    <li><a href="#">Coffees</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('reservation') }}">Reservation</a></li>
                            <li><a href="https://api.whatsapp.com/send?phone=6281260899294">Live Chat</a></li>
                            <li><a href="{{ route('reservation') }}">Reservation</a></li>
                            <li><a href="{{ route('location') }}">Lokasi</a></li>
                            <li><a href="{{ route('ulasan') }}">Ulasan</a></li>
                            <li style="position: fixed; right: 10px;">
                                @if (Auth::check())
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary px-3">Logout</button>
                                </form>
                                @else
                                <button type="button" onclick="location.href='{{ route('login') }}'" class="btn btn-primary px-3">Login</button>
                                @endif

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>