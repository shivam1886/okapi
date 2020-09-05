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
										<a class="button" href="{{route('supplier.vendor.index')}}">Clear</a>
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
										<h2>Market Place</h2>
									</div>
								</div>

								<div class="col-md-6 col-sm-12 col-xs-12">
								{{-- 	<form action="{{route('supplier.vendor.index')}}" method="get">
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
											@if($vendor->is_request)
                                                <button class="cancel-request-btn remove" data-url="{{route('supplier.cancel.request',$vendor->id)}}">Cancel Request</button>
                                            @else
                                                <button class="request-btn" data-url="{{route('supplier.vendor.request',$vendor->id)}}">Request</button>
                                            @endif
                                           <a href="{{route('supplier.vendor.show',$vendor->id)}}">Details</a>
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
  	$('body').on('click','.request-btn',function(e){
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
                  setTimeout(function(e){ window.location.href = "{{route('supplier.vendor.index')}}" },2000); 
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

  	 $('body').on('click','.cancel-request-btn',function(e){
  		    e.preventDefault();
	        var click = $(this);
            var url   = click.attr('data-url');
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'delete',
				'url' : url,
			beforeSend: function() {

			},
			'success' : function(response){
				if(response.status == 'success'){
   			      swal("Success!",response.message, "success");
                  setTimeout(function(e){ window.location.href = "{{route('supplier.vendor.index')}}" },2000); 
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