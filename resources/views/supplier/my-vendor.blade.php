@extends('layouts.loggedInApp')
@section('content')
                 <div class="main-body">

                    <!-----START searching box--------->
					<section class="searching-filter">
						<form method="GET">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="row">
										<div class="col-md-12">
											<div class="input">
												<input type="text" placeholder="Search by business name" name="search" value="{{Request::get('search')}}">
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="filter-btn">
										<a class="button" href="{{route('supplier.my.vendor')}}">Clear</a>
										<button class="button" type="submit">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</section>
					<!-----END searching box--------->

					<div class="inner-body">
						<!--header-->
						<div class="header distance-wrapper">
							<div class="row">
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="title">
										<h2>Close Vendore List</h2>
									</div>
								</div>

								<div class="col-md-6 col-sm-12 col-xs-12">
							{{-- 		<form action="{{route('supplier.my.vendor')}}" method="get">
										<div class="distance">
											<label>In Distance Range</label>
											<div class="km">
												<input type="text" value="{{Request::get('km')}}" name="km">
												<span>KM</span>
											</div>

											<button>Apply</button>
										</div>
									</form> --}}
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="supplier-request market-place">
							<div class="row">
								@forelse($data['vendors'] as $vendor)
								<!--single-s-request-->
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="single-s-request">
										<div class="img-text clearfix">
											<div class="img">
												<img onerror="profileImgError(this)" src="{{$vendor->profile_image}}">
											</div>
											<div class="txt">
												<h2>{{$vendor->business_name}}</h2>
												<p><i class="fas fa-map-marker-alt"></i>{{$vendor->address}}</p>
												{{-- @if($vendor->is_distance)
 												  <label>({{$vendor->distance}} km away)</label>
 												@else
 												  <label>Distance not available</label>
 												@endif --}}
											</div>
										</div>
										<div class="buttons txt">
                                           <button class="remove-btn remove" data-url="{{route('supplier.vendor.remove',$vendor->id)}}">Remove</button>
                                           <a href="{{route('supplier.my.vendor.details',$vendor->id)}}">Details</a>
										</div>
									</div>
								</div><!--END single-s-request-->
								@empty
								@endforelse
							</div>
						</div><!--END my tenders-->

					</div>	
				</div>
@endsection
@push('js')
  <script type="text/javascript">
  	$('body').on('click','.remove-btn',function(e){
  		    e.preventDefault();
	        var click = $(this);
            var url   = click.attr('data-url');
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'POST',
				'url' : url,
			beforeSend: function() {

			},
			'success' : function(response){
				if(response.status == 'success'){
   			      swal("Success!",response.message, "success");
                  setTimeout(function(e){ window.location.href = "{{route('supplier.my.vendor')}}" },1000); 
				}
				if(response.status == 'failed'){
				  swal("Failed!",response.message, "error");
				}
			},
			'error' : function(error){
				console.log(error);
			},
			complete: function() {

			},
			});
  	});
  </script>
@endpush