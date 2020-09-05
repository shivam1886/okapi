@extends('layouts.loggedInApp')
@section('content')
	<div class="main-body">
					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
											<a href="{{route('admin.suppliers')}}">Supplier List</a>
											<a href="javascript:void(0)">Supplier Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Supplier ID:#{{$data['supplier']->id}}</label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<div class="profile-details">
										<div class="profile-star clearfix">
											<div class="img">
												<img onerror="profileImgError(this)" src="{{$data['supplier']->profile_image}}" class="img-responsive">
											</div>

											<div class="star">
												<h2><img class="betch" src="{{asset('public')}}/images/betch.png">@if($data['supplier']->is_verified == '1') Verified Supplier @else Supplier not verified @endif </h2>

												<div class="star-rating">
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
												</div>
											</div>
										</div>

									    <div class="active-inactive" style="margin: 15px 0; display: inline-block;">
											<button data-status="{{$data['supplier']->is_verified == '1' ?  0 : 1 }}" class="form-control change-status" style="background: #000; color: #fff;">@if($data['supplier']->status == '1')Deactive @else Active @endif</button>
										 </div>
										 &nbsp;
										<div class="active-inactive" style="margin: 15px 0; display: inline-block;">
											<button data-status="{{$data['supplier']->is_verified == '1' ?  0 : 1 }}" class="form-control approve-user" style="background: #000; color: #fff;">@if($data['supplier']->is_verified == '1') Unverify @else Verify @endif</button>
										</div>

										<div class="input-details">
											<div class="form-group">
												<p class="form-control">{{$data['supplier']->name}}</p>
											</div>
											<div class="form-group">
												<p class="form-control">{{$data['supplier']->email}}</p>
											</div>
											<div class="form-group">
												<p class="form-control">{{$data['supplier']->phone}}</p>
											</div>

											<h2 class="title">Other Details</h2>

											<div class="form-group">
												<p class="form-control">{{$data['supplier']->business_name}}</p>
											</div>
											<div class="form-group">
												<p class="form-control">{{$data['supplier']->address}}</p>
											</div>
										</div>

									</div>
								</div><!--END supplier profile-->

								<!--supplier documents-->
								<div class="col-md-5 col-sm-5 col-xs-12">
									<div class="supplier-documents">
										<h2>Business Details & Documents</h2>

										<div class="documents clearfix">
											@if($data['supplier']->documents)
												   @foreach($data['supplier']->documents as $key => $document)
													<!--single-document-->
													<div class="single-document">
														<p>{{$document->title}}</p>
														<label class="img">
															<a href="{{$document->document}}" class="download-btn" download=""><i class="fas fa-download"></i></a>
															<img onerror="documentImgError(this)" src="{{$document->document}}">
														</label>
														<select data-id="{{$document->id}}" class="form-control approve-document" style="margin-top: 5px;">
															<option @if($document->is_varified == '1') selected @endif value="1">Verify</option>
															<option @if($document->is_varified == '2') selected @endif value="2">Reject</option>
														</select>
													</div><!--end-->
												@endforeach
											@endif
										</div>
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
         var id     = "{{$data['supplier']->id}}";
         if(status == '1')
         	  var text = 'active';
         else
         	var text = 'deactive';
         	data = {id:id,status:status};
  	  	 swal({
		  title: "Are you sure?",
		  text: "What to "+text+" this supplier",
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
					'url' : '{{route('admin.supplier.status')}}',
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

  	  	$('body').on('change','.approve-document',function(e){
	       e.preventDefault();
	         var click  = $(this);
	         var status = $(this).val();
	         var id     = $(this).attr('data-id');
	         if(status == '1')
	         	  var text = 'approve';
	         else
	         	var text = 'reject';
	         	data = {id:id,status:status};
	  	  	 swal({
			  title: "Are you sure?",
			  text: "What to "+text+" this document",
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
						'url' : '{{route('admin.approve.document')}}',
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

  	  	$('body').on('click','.approve-user',function(e){
	       e.preventDefault();
	         var click  = $(this);
             var status = $(this).attr('data-status');
	         var id     = "{{$data['supplier']->id}}";
	         if(status == '1')
	         	  var text = 'approve';
	         else
	         	var text = 'reject';
	         	data = {id:id,status:status};
	  	  	 swal({
			  title: "Are you sure?",
			  text: "What to "+text+" this supplier",
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
						'url' : '{{route('admin.approve.supplier')}}',
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