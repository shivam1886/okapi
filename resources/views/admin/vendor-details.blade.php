@extends('layouts.loggedInApp')
@section('content')
				<div class="main-body">

					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
											<a href="my_vendors.html">Close Vendor List</a>
											<a href="Myvendor-details.html"> Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Vendor ID:#{{$data['vendor']->id}}</label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details Myvendor-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<div class="profile-details">
										<div class="profile-star clearfix">
											<div class="img">
												<img onerror="profileImgError(this)" src="{{$data['vendor']->profile_image}}" class="img-responsive">
											</div>
										</div>
												
										  <div class="active-inactive" style="margin: 15px 0; display: inline-block;">
											<button data-status="{{$data['vendor']->status == '1' ?  0 : 1 }}" class="form-control change-status" style="background: #000; color: #fff;">@if($data['vendor']->status == '1') Deactive @else Active @endif</button>
										 </div>
 
										<div class="input-details">
											<div class="form-group">
												<input class="form-control" type="text" placeholder="Title" name="" value="{{$data['vendor']->title}}" readonly>
											</div>
											<div class="form-group">
												<input class="form-control" type="text" placeholder="Name" name="" value="{{$data['vendor']->name}}" readonly>
											</div>
											<div class="form-group">
												<input type="email" value="{{$data['vendor']->email}}" placeholder="Email" class="form-control" name="" readonly>
											</div>
											<div class="form-group">
												<input type="text" value="{{$data['vendor']->phone}}" placeholder="Number" class="form-control" name="" readonly>
											</div>

											<h2 class="title">Other Details</h2>

											<div class="form-group">
												<input type="text" value="{{$data['vendor']->business_name}}" class="form-control" placeholder="Business Name" name="" readonly>
											</div>
											<div class="form-group">
												<textarea rows="" class="form-control" placeholder="Address" readonly>{{$data['vendor']->address}}</textarea>
											</div>

											<div class="row">
												<div class="col-md-4 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" value="{{$data['vendor']->city}}" class="form-control" placeholder="City" name="" readonly>
													</div>
												</div>
												<div class="col-md-4 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" value="{{$data['vendor']->state}}" class="form-control" placeholder="State" name="" readonly>
													</div>
												</div>
												<div class="col-md-4 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" value="{{$data['vendor']->country}}" class="form-control" placeholder="Country" name="" readonly>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div><!--END supplier profile-->

								<!--supplier documents-->
								<div class="col-md-5 col-sm-5 col-xs-12">
									<div class="supplier-documents">

										@foreach($data['vendor']->departments as $department)
										<!--single-department-->
										<div class="single-department">
											<div class="form-group">
												<label>Department Name</label>
												<p>{{$department->name}}</p>
											</div>

											<div class="form-group">
												<label>Contact Number</label>
												<p>{{$department->phone}}</p>
											</div>

											<div class="form-group">
												<label>Email Address</label>
												<p>{{$department->email}}</p>
											</div>
										</div><!--end single-department-->
									  @endforeach
									</div>
								</div><!--END supplier documents-->

							</div>
						</div><!--END supplier-details-->
					</div>
				</div>
@endsection
@push('js')
  <script type="text/javascript">

  	  	$('body').on('click','.change-status',function(e){
         e.preventDefault();
         var click  = $(this);
         var status = $(this).attr('data-status');
         var id     = "{{$data['vendor']->id}}";
         if(status == '1')
         	  var text = 'active';
         else
         	var text = 'deactive';
         	data = {id:id,status:status};
  	  	 swal({
		  title: "Are you sure?",
		  text: "What to "+text+" this vendor",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		 })
		 .then((willDelete) => {
			if(!willDelete){
				return false;
			}

          var id = $(this).attr('data-id');
				$.ajax({
					"headers":{
					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
				},
					'type':'PUT',
					'url' : '{{route('admin.vendor.status')}}',
					'data' : data,
				beforeSend: function() {
				},
				'success' : function(response){
					if(response.status == 'success'){
						swal("Success!",response.message, "success");
						setTimeout(function(){ location.reload(); }, 1500);
					}
					if(response.status == 'failed'){
						swal("Failed!",response.message, "error");
					}
				},
				'error' : function(error){
				},
				complete: function() {
				},
				});

		 });
  	  	});

  </script>
@endpush