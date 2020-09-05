<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
	<meta name="keywords" content="cleaning, home">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--css-->
	<link rel="stylesheet" type="text/css" href="{{asset('public')}}/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('public')}}/css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('public')}}/css/style.css">{{asset('public')}}/
	<link rel="stylesheet" type="text/css" href="{{asset('public')}}/css/responsive.css">
	<!--font awesome 4-->
	<link rel="stylesheet" type="text/css" href="{{asset('public')}}/fonts/fontawesome/css/all.min.css">
	<!--data table-->
	<link rel="stylesheet" type="text/css" href="{{asset('public')}}/css/dataTables.bootstrap.css">
	@stack('css')
	<script type="text/javascript">

	function profileImgError(image) {
		image.onerror = "";
		image.src = "{{asset('public/images/user-default-image.png')}}";
		return true;
	}

	function documentImgError(image) {
		image.onerror = "";
		image.src = "{{asset('public/images/default-image.png')}}";
		return true;
	}
</script>
</head>
<body onload="loaderfun()">
	<div id="loader-wrapper">
		<div id="loader">
			<div class="svg-wrapper">
				<img src="{{asset('public')}}/images/loader1.gif">
			</div>
		</div>
	</div>
	<main class="clearfix">
		<!--left block-->
		<div class="left-block">
			<button class="close-menu">
				<i class="fa fa-times"></i>
			</button>
			<div class="left-block-body">
				<nav>
					<div class="nav-logo">
						<a href="{{route('home')}}">
							<img src="{{asset('public')}}/images/nav-logo2.png" class="logo">
							<img src="{{asset('public')}}/images/logo-icon.png" class="logo-icon">
						</a>
					</div>

					<div class="navlink">
						<ul>
							<li>
									<a href="{{route('home')}}"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
							</li>
							
							@if(auth::user()->user_type == '1')
								<li><a href="{{route('admin.vendors')}}"><i class="fa fa-list-alt"></i> <span>Vendors</span></a></li>
								<li><a href="{{route('admin.suppliers')}}"><i class="fa fa-list-alt"></i> <span>Suppliers</span></a></li>
							@endif

							@if(auth::user()->user_type == '2' || auth::user()->user_type == '4')
								<li>
									<a href="{{route('vendor.tendor.create')}}"><i class="fa fa-plus"></i> <span>Add Tenders</span></a>
								</li>
								<li>
									<a href="{{route('vendor.tendor.index')}}"><i class="fa fa-list-alt"></i> <span>Tenders</span></a>
								</li>
								<li>
									<a href="{{route('vendor.quotation.list')}}"><i class="fa fa-hand-holding-usd"></i> <span>Seller Quotations</span></a>
								</li>
								<li>
									<a href="{{route('vendor.request.index')}}"><i class="fa fa-list"></i> <span>Supplier Request</span></a>
								</li>
								<li>
								<a href="{{route('vendor.supplier.index')}}"><i class="fa fa-clipboard-list"></i> <span>Supplier List</span></a>
								</li>
								    <li>
										<a href="{{route('vendor.order.index')}}"><i class="fa fa-tasks"></i> <span>My Orders</span></a>
									</li>
							@endif

							@if(auth::user()->user_type == '3' || auth::user()->user_type == '4')
							    <li>
									<a href="{{route('supplier.tendor.index')}}"><i class="fa fa-list-alt"></i> <span>Explore Tenders</span></a>
								</li>
								<li>
									<a href="{{route('supplier.vendor.index')}}"><i class="fas fa-chart-pie"></i> <span>Market Place</span></a>
								</li>
								<li>
									<a href="{{route('supplier.my.vendor')}}"><i class="fa fa-tasks"></i> <span>My Vendors</span></a>
								</li>
							    <li>
									<a href="{{route('supplier.quotation.index')}}"><i class="fa fa-hand-holding-usd"></i> <span>My Quotation</span></a>
								</li>
								   @if(auth::user()->user_type == '3')
									 <li>
										<a href="{{route('supplier.order.index')}}"><i class="fa fa-tasks"></i> <span>My Orders</span></a>
									</li>
									@endif
								<li>
									<a href="{{route('supplier.product.index')}}"><i class="fas fa-box-open"></i> <span>Product & Catalogue</span></a>
								</li>
							@endif

							<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-in-alt"></i>  {{ __('Logout') }}</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
							</form></li>

						</ul>
					</div>
				</nav>
			</div>
		</div>
		<!--left block end-->

		<!--right-block-->
		<div class="right-block">
			<div class="Navoverlay"></div>
			<div class="right-block-body">
				<div class="top-nav">
					<div class="nav-item clearfix">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-3">
								<div class="left-item">
									<button class="toggle-btn"><i class="fa fa-bars"></i></button>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 d-none-m">
								@if(auth::user()->user_type == '1')
								 <div class="title">Admin</div>
								@endif
								@if(auth::user()->user_type == '2')
								 <div class="title">Vendor</div>
								@endif
								@if(auth::user()->user_type == '3')
								 <div class="title">Supplier</div>
								@endif
								@if(auth::user()->user_type == '4')
								  <div class="title">Supplier & Vendor</div>
								@endif
							</div>
							<div class="col-md-4 col-sm-4 col-xs-9 text-right">
								<div class="right-item">
 									<div class="notification-card">
 										<button class="notification noty-btn"> <i class="fa fa-bell"></i>
 											@if(count(auth::user()->notifications->where('is_read','!=','1')) > 0)
 											<span>&nbsp;</span>
 											@endif
 										</button>

 										<div class="noty-body">
 											<ul></ul>
 										</div>

 									</div>
									<div class="user-profile">
										@if(auth::user()->user_type == '1')
										   <a href="{{route('admin.profile')}}">
									    @endif
										@if(auth::user()->user_type == '2')
										<a href="{{route('vendor.profile')}}">
										@endif
										@if(auth::user()->user_type == '3')
										<a href="{{route('supplier.profile')}}">
										@endif
										@if(auth::user()->user_type == '4')
										<a href="{{route('supplier.vendor.profile')}}">
										@endif
											<img onerror="profileImgError(this)" src="{{auth::user()->profile_image}}" alt="profile" class="img-responsive">
										</a>
										<span>
											<h2>{{auth::user()->name}}</h2>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!------right block body-->
                @section('content')@show
			</div>
		</div>
		<!--right-block end-->

	</main>
<!--script-->
<script type="text/javascript" src="{{asset('public')}}/js/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/bootstrap.min.js"></script>
<!--data table-->
<script type="text/javascript" src="{{asset('public')}}/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/custom.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/sweetalert.min.js"></script>
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGQC7r17YyESlAGS8raZ0G1Q-r9Q1s4Vk&?sensor=false&libraries=places" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/js/')}}/locationpicker.jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/js/')}}/location.js"></script> --}}
<script type="text/javascript">
      $('[href="'+window.location.href+'"]').addClass('active');
      $('[data-toggle="tooltip"]').tooltip();
      $('body').on('click','.notification-form',function(e){
      	 $(this).submit();
      });
      $(function(){
		  // Get Documents
		  	    var getNotification = function(){
							$.ajax(
							{
								"headers":{
								'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
							},
								'type':'get',
								'url' : "{{route('get.notifications')}}",
							beforeSend: function() {

							},
							'success' : function(response){
		              	        $('.noty-body ul').html(response);
							},
		  					'error' : function(error){
							},
							complete: function() {
							},
							});
		  	    }
		  	    setInterval(function(){ getNotification(); },2000);
      })
</script>
@stack('js')
</body>
</html>