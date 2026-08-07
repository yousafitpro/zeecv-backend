<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | Scalify</title>
    <link href="{{asset('themes/eshoper/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/eshoper/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/eshoper/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('themes/eshoper/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('themes/eshoper/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('themes/eshoper/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('themes/eshoper/css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('app-icons/favicon_io/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('app-icons/favicon_io/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('app-icons/favicon_io/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('app-icons/favicon_io/site.webmanifest')}}">
<style>
            :root{
        --primary:#28a5ab !important;
        --blue:#28a5ab !important;
        --link-color:rgb(0, 120, 212) !important;
    }

</style>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +1 (601) 305-3609</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@scalifypro.net</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{url('/')}}"><img src="{{asset('themes/eshoper/images/home/logo.png')}}" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							{{-- <div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div> --}}
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">

								<li><a href="{{route('frontend.shop')}}"><i class="fa fa-home"></i> Shop</a></li>
                                <li><a href="{{route('tutorial.list')}}"><i class="fa fa-book"></i> Tutorials</a></li>
                                	<li><a href="{{route('signup')}}"><i class="fa fa-user"></i> Register</a></li>

								<li><a href="{{route('login')}}"><i class="fa fa-lock"></i> Login</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		{{-- <div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.html" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Products</a></li>
										<li><a href="product-details.html">Product Details</a></li>
										<li><a href="checkout.html">Checkout</a></li>
										<li><a href="cart.html">Cart</a></li>
										<li><a href="login.html">Login</a></li>
                                    </ul>
                                </li>
								<li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li>
								<li><a href="404.html">404</a></li>
								<li><a href="contact-us.html">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom--> --}}
	</header><!--/header-->

@yield('content')

	<footer id="footer"><!--Footer-->
		{{--<div class="footer-top">
			<div class="container">
				 <div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>Scalify</span>Pro</h2>
							<p>Innovating today for a smarter tomorrow.
Turning ideas into impactful solutions.</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('themes/eshoper/images/home/iframe1.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('themes/eshoper/images/home/iframe2.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('themes/eshoper/images/home/iframe3.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('themes/eshoper/images/home/iframe4.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{asset('themes/eshoper/images/home/map.png')}}" alt="" />
							<p>Noble Crest Inc 16405 County Road 48, Cutchogue, NY 11935</p>
						</div>
					</div>
				</div>
			</div>
		</div>--}}

		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
							<li>
                            <a href="https://wa.me/16013053609" target="_blank">
                               Online Help
                            </a>
                            </li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="{{url('page-view/terms')}}">Terms of Use</a></li>
								<li><a href="{{url('page-view/privacy-policy')}}">Privecy Policy</a></li>
								<li><a href="{{url('page-view/refund-policy')}}">Refund Policy</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="{{route('signup')}}">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4 col-sm-offset-1">
						<div class="single-widget">
							<div class="address">
							<img src="{{asset('themes/eshoper/images/home/map.png')}}" alt="" />
							<p>Noble Crest Inc,
515 Clubhouse Drive, Middletown, New Jersey 07748</p>
						</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2025 Scalify Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="{{url('/')}}">scalifypro.net</a></span></p>
				</div>
			</div>
		</div>

	</footer><!--/Footer-->



    <script src="{{asset('themes/eshoper/js/jquery.js')}}"></script>
	<script src="{{asset('themes/eshoper/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('themes/eshoper/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('themes/eshoper/js/price-range.js')}}"></script>
    <script src="{{asset('themes/eshoper/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('themes/eshoper/js/main.js')}}"></script>
</body>
</html>
