@extends('layouts.loggedInApp')
@section('content')
                 <div class="main-body">

					<div class="inner-body">
						<!--header-->
						<div class="header distance-wrapper">
							<div class="row">
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="title">
										<h2>Vendors List</h2>
									</div>
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
												<h2>{{$vendor->name}}</h2>
												<p><i class="fas fa-map-marker-alt"></i>{{$vendor->address}}</p>
											</div>
										</div>
										<div class="buttons txt">
                                           <a href="{{route('admin.vendor.details',$vendor->id)}}">Details</a>
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