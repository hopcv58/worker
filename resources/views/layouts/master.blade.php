<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documentation - Bootflat</title>
    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- SmartAddon.com Verification -->
    <meta name="smartaddon-verification" content="936e8d43184bc47ef34e25e426c508fe"/>
    <meta name="keywords"
          content="Flat UI Design, UI design, UI, user interface, web interface design, user interface design, Flat web design, Bootstrap, Bootflat, Flat UI colors, colors">
    <meta name="description" content="The complete style of the Bootflat Framework.">
    <!-- site css -->
    <link rel="stylesheet" href="{{asset('css/my.css')}}">
    <link rel="stylesheet" href="{{asset('bootflat/css/site.min.css')}}">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic"
          rel="stylesheet" type="text/css">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{asset('bootflat/css/js/html5shiv.js')}}"></script>
    <script src="{{asset('bootflat/js/respond.min.js')}}"></script>
    <![endif]-->
    <script src="{{asset('js/js.cookie.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootflat/js/site.min.js')}}"></script>
</head>
<body style="background-color: #f1f2f6;">
<div class="docs-header">
    <!--nav-->
    <nav class="navbar navbar-default navbar-custom" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{asset('bootflat/img/logo.png')}}" height="40">
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"> Category <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('categories.index')}}">Index</a></li>
                            <li><a href="{{route('categories.create')}}">Create</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"> Transaction <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('transactions.index')}}">Index</a></li>
                            <li><a href="{{route('transactions.create')}}">Create</a></li>
                        </ul>
                    </li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown current">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"> Worker <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('workers.index')}}">Index</a></li>
                                <li><a href="{{route('workers.create')}}">Create</a></li>
                                <li><a href="{{route('workers.addForm')}}">Add new service</a></li>
                                <li><a href="{{route('workers.edit')}}">Update Worker's info</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <span><img class="avatar"
                                           src="{{Auth::user()->avatar_path}}"></span>{{ Auth::user()->name }} <span
                                        class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('profile')}}">Profile</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
                <form class="navbar-form navbar-search pull-right" method="GET" action="{{route('search')}}">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-search btn-default dropdown-toggle"
                                    data-toggle="dropdown">
                                <span class="label-icon">Select Category</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-left" role="menu">
                                @foreach($grand_categories as $grand_category)
                                    <li>
                                        <a href="#" value="{{$grand_category->id}}">{{$grand_category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input name="category" id="category_navbar" hidden="">
                        <input name="address" id="address_navbar" type="text" class="form-control">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-search btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                                <span class="label-icon">Search</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <!--header-->
    <div id="topicCarousel" class="carousel slide" data-ride="carousel">
    {{--<!-- Indicators -->--}}
    {{--<ol class="carousel-indicators">--}}
    {{--<li data-target="#topicCarousel" data-slide-to="0" class="active"></li>--}}
    {{--<li data-target="#topicCarousel" data-slide-to="1"></li>--}}
    {{--<li data-target="#topicCarousel" data-slide-to="2"></li>--}}
    {{--<li data-target="#topicCarousel" data-slide-to="3"></li>--}}
    {{--</ol>--}}

    <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="http://a.rpassets.com/rpsite/p304/assets/bundles/rppages/img/heroes/hohp-first.jpg"
                     alt="First">
                <div class="carousel-caption">
                    <h2>The home you deserve. Sorted.</h2>
                    <h4>Find a tradesman for every job. From light fittings
                        and loft conversions, to leaky taps and a lick of paint.</h4>
                </div>
            </div>

            <div class="item">
                <img src="http://a.rpassets.com/rpsite/p304/assets/bundles/rppages/img/heroes/hohp-second.jpg"
                     alt="Second">
                <div class="carousel-caption">
                    <h2>Last minute jobs. Sorted.</h2>
                    <h4>Get those everyday jobs done fast. From broken boilers
                        and burst pipes, to leaks and blocked drains.</h4>
                </div>
            </div>

            <div class="item">
                <img src="http://a.rpassets.com/rpsite/p304/assets/bundles/rppages/img/heroes/hohp-third.jpg"
                     alt="Third">
                <div class="carousel-caption">
                    <h2>Home management. Sorted.</h2>
                    <h4>We cover everything from electrics and plumbing to
                        decorating and roof repair.</h4>
                </div>
            </div>

            <div class="item">
                <img src="http://a.rpassets.com/rpsite/p304/assets/bundles/rppages/img/heroes/hohp-fourth.jpg"
                     alt="Fourth">
                <div class="carousel-caption">
                    <h2>Home improvement. Sorted.</h2>
                    <h4>Extra bedrooms, a granny flat, a new bathroom or kitchen -
                        improvements that make a huge difference.</h4>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#topicCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#topicCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@yield('header')
<!--documents-->
</div>
<div class="container documents">
    @yield('content')
</div>
<!--footer-->
<link href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<!--footer start from here-->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 footerleft ">
                <div class="logofooter"> Logo</div>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
                <p><i class="fa fa-map-pin"></i> 210, Aggarwal Tower, Rohini sec 9, New Delhi -        110085, INDIA</p>
                <p><i class="fa fa-phone"></i> Phone (India) : +91 9999 878 398</p>
                <p><i class="fa fa-envelope"></i> E-mail : info@webenlance.com</p>

            </div>
            <div class="col-md-2 col-sm-6 paddingtop-bottom">
                <h6 class="heading7">GENERAL LINKS</h6>
                <ul class="footer-ul">
                    <li><a href="#"> Career</a></li>
                    <li><a href="#"> Privacy Policy</a></li>
                    <li><a href="#"> Terms & Conditions</a></li>
                    <li><a href="#"> Client Gateway</a></li>
                    <li><a href="#"> Ranking</a></li>
                    <li><a href="#"> Case Studies</a></li>
                    <li><a href="#"> Frequently Ask Questions</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 paddingtop-bottom">
                <h6 class="heading7">LATEST POST</h6>
                <div class="post">
                    <p>facebook crack the movie advertisment code:what it means for you <span>August 3,2015</span></p>
                    <p>facebook crack the movie advertisment code:what it means for you <span>August 3,2015</span></p>
                    <p>facebook crack the movie advertisment code:what it means for you <span>August 3,2015</span></p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 paddingtop-bottom">
                <div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline"
                     data-height="300" data-small-header="false" style="margin-bottom:15px;"
                     data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <div class="fb-xfbml-parse-ignore">
                        <blockquote cite="https://www.facebook.com/facebook"><a
                                    href="https://www.facebook.com/facebook">Facebook</a></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer start from here-->

<div class="copyright">
    <div class="container">
        <div class="col-md-6">
            <p>© 2016 - All Rights with Webenlance</p>
        </div>
        <div class="col-md-6">
            <ul class="bottom_ul">
                <li><a href="#">Will edit soon</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Faq's</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="#">Site Map</a></li>
            </ul>
        </div>
    </div>
</div>
@yield('extra_js')
{{--<script>

    function initMap() {
        var input = document.getElementById('address_navbar');

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2sz2ks3hz-4W9jzzyxw-UP3dJXBkR9tg&libraries=places&callback=initMap"
        async defer></script>--}}
<script>
    $(function () {
        $(".input-group-btn .dropdown-menu li a").click(function () {
            var selText = $(this).html();
            var selVal = $(this).attr("value");
            $(this).parents('.input-group-btn').find('.btn-search').html(selText);
            $("#category_navbar").val(selVal);
        });
    });
</script>
</body>
</html>
