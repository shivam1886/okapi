@extends('layouts.loggedInApp')
@section('content')
<div class="main-body">
@include('common.alert')
					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
   										   <a href="javascript::void(0)">My Profile</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Account ID: #{{auth::id()}}</label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<form method="POST" action="{{ route('vendor.update.profile') }}" id="update-profile-form" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT')}}
										<div class="profile-details">
											<div class="profile-star clearfix">
												<div class="img">
													<span class="edit"><i class="fas fa-pencil-alt"></i></span>
													<label>
															<img onerror="profileImgError(this);" src="{{$data['user']->profile_image}}" class="img-responsive image-preview">
															<input type="file" name="profile_image" accept="image/*">
													</label>
												</div>

												<div class="star">
													<button type="submit">Save Profile</button>
												</div>
											</div>
											<div class="input-details">
												<div class="form-group">
												<input class="form-control" type="text" placeholder="Name" name="name" value="{{old('name') ?? $data['user']->name}}" class="{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
													@if ($errors->has('name'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('name') }}</strong>
														</span>
													@endif
												</div>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Title" name="title" value="{{old('title') ?? $data['user']->title}}" class="{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
														@if ($errors->has('title'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('title') }}</strong>
														</span>
													@endif
												</div>
												<div class="form-group">
													<input type="email" placeholder="Email" class="form-control" name="email" value="{{old('email') ?? $data['user']->email}}" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
														@if ($errors->has('email'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('email') }}</strong>
														</span>
													@endif
												</div>
												<div class="form-group">
													<input type="text" placeholder="Number" class="form-control" name="phone" value="{{old('phone') ?? $data['user']->phone}}" class="{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}">
														@if ($errors->has('phone'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('phone') }}</strong>
														</span>
													@endif
												</div>

												<h2 class="title">Other Details</h2>

												<div class="form-group">
													<input type="text" class="form-control" placeholder="Business Name" name="business_name" value="{{old('business_name') ?? $data['user']->business_name}}" class="{{ $errors->has('business_name') ? ' is-invalid' : '' }}" value="{{ old('business_name') }}">
														@if ($errors->has('business_name'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('business_name') }}</strong>
														</span>
													@endif
												</div>
												<div class="form-group">
													<textarea rows="" class="form-control" id="address" name="address" placeholder="Address" class="{{ $errors->has('address') ? ' is-invalid' : '' }}">{{old('address') ?? $data['user']->address}}</textarea>
															<input type="hidden" value="{{$data['user']->latitude}}" name="latitude"  id="latitude" name="">
														<input type="hidden" value="{{$data['user']->longitude}}" name="longitude" id="longitude" name="">
														@if ($errors->has('address'))
															<span class="invalid-feedback" role="alert">
															   <strong>{{ $errors->first('address') }}</strong>
															</span>
													    @endif
												</div>

												<div class="row">
													<div class="col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="City" name="city" value="{{old('city') ?? $data['user']->city}}" class="{{ $errors->has('city') ? ' is-invalid' : '' }}" value="{{ old('city') }}">
																@if ($errors->has('city'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('city') }}</strong>
														</span>
													@endif
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="State" name="state" value="{{old('state') ?? $data['user']->state}}" class="{{ $errors->has('state') ? ' is-invalid' : '' }}" value="{{ old('state') }}">
																@if ($errors->has('state'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('state') }}</strong>
														</span>
													@endif
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="Country" name="country" {{old('country') ?? $data['user']->country}} class="{{ $errors->has('country') ? ' is-invalid' : '' }}" value="{{ old('country') ?? $data['user']->country }}">
																@if ($errors->has('country'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('country') }}</strong>
														</span>
													@endif
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>

									  <!--change pass-->
									<div class="supplier-documents">
								 		<form method="POST" action="{{ route('change.password') }}" id="change-password">
								 			@csrf
								 			{{ method_field('PUT')}}
									    	<!--single-department-->
											<div class="single-department add-department" style="max-width: 500px; margin: 20px 0 0;">
												<h2>Change Password</h2>
												<div class="form-group">
													<input type="password" placeholder="Current Password" value="" name="old_password">
												</div>

												<div class="form-group">
													<input type="password" placeholder="New Password" value="" name="new_password">
												</div>

												<div class="form-group">
													<input type="password" placeholder="Confirm Password" value="" name="confirm_password">
												</div>

												<div class="add-btn">
													<button type="submit">Change Password</button>
												</div>
											</div><!--end-->
										</form>
								    </div>
								    <!--change pass-->

								</div><!--END supplier profile-->

								<!--supplier documents-->
								<div class="col-md-5 col-sm-5 col-xs-12">

									   <div class="supplier-documents my-documents">
											<h2>Business Details &amp; Documents</h2>

											<div class="documents clearfix">
												@foreach($data['user']->documents as $key => $document)
												<!--single-document-->
												<div class="single-document">
													<p>{{$document->title}}</p>
													<div class="img-wrapper @if($document->is_varified == '1') veryfied @elseif($document->is_varified == '2') decline @else  @endif">
														<span class="txt">@if($document->is_varified == '1') veryfied @elseif($document->is_varified == '2') decline @else Pending @endif</span>
														<i class="far fa-times-circle delete-img remove-document" data-url="{{route('supplier.remove.document',$document->id)}}"></i>
														<label class="img">
															<a href="{{$document->document}}" class="download-btn" download><i class="fas fa-download"></i></a>
															<img 	onerror="documentImgError(this);" src="{{$document->document}}">
														</label>
													</div>
												</div><!--end-->
												@endforeach

											</div>

											<div class="upload-new">
												<h2>Upload New Documents</h2>
                                                <form method="POST" action="{{route('supplier.update.document')}}" id="document-update-form" enctype="multipart/form-data">
	                                                @csrf
													<div class="clearfix single-upload-img-wrapper" id="documentList">
													</div>
												 <button type="submit" class="proceed-btn">Proceed to Verify</button>
											    </form>
												<button class="add-document">Add Document</button>
											</div>

										</div>

									   <!------------------------->

									<div class="added-tax">
										<span>Added Tax</span>
										<div class="tax-list"></div>
										<div class="gst add-tax">
											<form action="{{route('supplier.add.tax')}}" method="post" id="add-tax-form-new">
												@csrf
												<input class="tax" type="text" placeholder="title" value="" name="title" required>
												<input class="percentage" type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" placeholder="tax" value="" name="tax" required>
												<button><i class="fas fa-plus"></i></button>
											</form>
										</div>
									</div>

										<!--added-tax-->
									<div class="added-tax">
										<span>Added Currency</span><br>
										<div class="currency-list">
											@foreach($data['user']->currency as $currency)
											<div class="gst add-tax">
												<form action="{{route('vendor.currency.destroy',$currency->id)}}" method="post" id="dlt-currency-form">
												@csrf
												{{ method_field('DELETE')}}
												<input class="tax" type="text" placeholder="currency" value="{{$currency->title}}" name="currency" readonly>
												<button style="background: #e45863"><i class="fas fa-trash"></i></button>
												</form>
											</div>
											@endforeach
										</div>
										<div class="gst add-tax">
											<form action="{{route('vendor.currency.create')}}" method="post" id="add-currency-form">
												@csrf
												<input class="tax" type="text" placeholder="currency" max="3" name="currency" required>
												<button><i class="fas fa-plus"></i></button>
											</form>
										</div>
									</div><!--END added-tax-->

								</div><!--END supplier documents-->
							</div>
						</div><!--END supplier-details-->

					</div>	
				</div>
@endsection
@push('js')
  <script type="text/javascript">
      
      $('#document-update-form button').hide();

         // Get Currencys
  	    var getCurrencies = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "{{route('vendor.currency.list')}}",
					beforeSend: function() {

					},
					'success' : function(response){
              	        $('.currency-list').html(response);
					},
  					'error' : function(error){
					},
					complete: function() {
					},
					});
  	    }

  	  $('body').on('submit','#add-tax-form-new',function(e){
  	  	    e.preventDefault();
	        var click = $(this);
			let form  = $(this);
            let data = form.serialize();
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'POST',
				'url' : form.attr('action'),
				'data' : data,
			beforeSend: function() {

			},
			'success' : function(response){
 				  click.find('span').hide();
				if(response.status == 'success'){
                  getTaxes();
                  click.parents('.add-tax').find('form')[0].reset();			
   			      swal("Success!",response.message, "success");
				}
				if(response.status == 'failed'){
				  swal("Failed!",response.message, "error");
				}
				if(response.status == 'error'){
					 $.each(response.errors, function (key, val) {
					 click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
					 });
				}
			},
			'error' : function(error){
				console.log(error);
			},
			complete: function() {

			},
			});
  	  });

  	  	  $('body').on('submit','.remove-tax-form',function(e){
  	  	    e.preventDefault();
  	  	     swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this tax!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		 })
		 .then((willDelete) => {
			if(!willDelete){
				return false;
			}

	        var click = $(this);
			let form  = $(this);
            let data = form.serialize();
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'DELETE',
				'url' : form.attr('action'),
				'data' : data,
			beforeSend: function() {

			},
			'success' : function(response){
				if(response.status == 'success'){
                  getTaxes();
   			      swal("Success!",response.message, "success");
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

		});

  	  // Get Documents
  	    var getDocuments = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "{{route('supplier.document.list')}}",
					beforeSend: function() {

					},
					'success' : function(response){
              	        $('.document-list').html(response);
					},
  					'error' : function(error){
					},
					complete: function() {
					},
					});
  	    }


  	    // Get Taxes
  	    var getTaxes = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "{{route('supplier.tax.list')}}",
					beforeSend: function() {

					},
					'success' : function(response){
              	        $('.tax-list').html(response);
					},
  					'error' : function(error){
					},
					complete: function() {
					},
					});
  	    }

  	    getDocuments();
     	getTaxes();
  	  
  	  // store or update clinic
      $('#update-profile-form').on('submit',function(e){
			e.preventDefault();
			var click = $(this);
			let form  = $(this);
 		    let data  = new FormData(this);
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'POST',
				'url' : form.attr('action'),
				'data' : data,
				cache : false,
				contentType : false,
				processData : false,
			beforeSend: function() {

			},
			'success' : function(response){
 				  click.find('span').hide();
				if(response.status == 'success'){
   			      swal("Success!",response.message, "success");
				}
				if(response.status == 'failed'){
				  swal("Failed!",response.message, "error");
				}
				if(response.status == 'error'){
					 $.each(response.errors, function (key, val) {
					 click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
					 });
				}
			},
			'error' : function(error){
				console.log(error);
			},
			complete: function() {

			},
			});
      });

     var dynamicImageInput  = function () {
		    html = '';
			html +='<div class="single-upload-img">';
			html +='<div class="img">';
			html +='<i class="far fa-times-circle delete-img"></i>';
			html +='<label>';
			html +='<input type="file" name="documents[]" accept="image/*" required>';
			html +='<img src="{{asset('public/documents/default-image.png')}}">';
			html +='</label>';
			html +='</div>';
			html +='<input type="text" placeholder="Write here..." name="titles[]" required>';
			html +='</div>';
			return html;
     }

     $('body').on('click','.add-document',function(e){
			var x = $('#documentList .single-upload-img').length;
			if(parseInt(x) > 0)
                $('#document-update-form button').show();
			else
                $('#document-update-form button').hide();
     	 $('.single-upload-img-wrapper').append(dynamicImageInput());
     });

     $('body').on('click','.delete-img',function(e){
			var x = $('#documentList .single-upload-img').length;
			if(parseInt(x) < 1)
			    $('#document-update-form button').hide();
       	    $(this).parents('.single-upload-img').remove();
     });

     //Image Preview
	  $('input[name="profile_image"]').on('change',function(e){
	   	  tmppath = URL.createObjectURL(event.target.files[0]);
		  $('.image-preview').attr('src',tmppath);
	  });

	  $('body').on('change','input[type="file"]',function(event){
	  	 tmppath  = URL.createObjectURL(event.target.files[0]);
	  	 $(this).parents('label').find('img').attr('src',tmppath);
	  });

	  $('body').on('click','.remove-document',function(e){
	  	  var url = $(this).attr('data-url');
		  swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this document!",
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
					'url' : url,
					'data' : {id},
				beforeSend: function() {
				},
				'success' : function(response){
					if(response.status == 'success'){
						swal("Success!",response.message, "success");
	    	 		    setTimeout(function(){ location.reload(); }, 1000);
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

	   // store or update clinic
     $('#document-update-form').on('submit',function(e){
			e.preventDefault();
			var x = $('#documentList .single-upload-img').length;
			if(x == '0'){
				return false;
			}
			var click = $(this);
			let form  = $(this);
 		    let data  = new FormData(this);
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'POST',
				'url' : form.attr('action'),
				'data' : data,
				cache : false,
				contentType : false,
				processData : false,
			beforeSend: function() {

			},
			'success' : function(response){
				if(response.status == 'success'){
   			      swal("Success!",response.message, "success");
   	 		      setTimeout(function(){ location.reload(); }, 1000);
				}
				if(response.status == 'failed'){
				  swal("Failed!",response.message, "error");
				}
				if(response.status == 'error'){
					 $.each(response.errors, function (key, val) {
					 click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
					 });
				}
			},
			'error' : function(error){
				console.log(error);
			},
			complete: function() {

			},
			});
     });

      $('body').on('submit','#change-password',function(e){
	 	e.preventDefault();
	    var click = $(this);
		let form  = $(this);
	    let data = form.serialize();
		$.ajax({
			"headers":{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		},
			'type':'PUT',
			'url' : form.attr('action'),
			'data' : data,
		beforeSend: function() {

		},
		'success' : function(response){
				click.find('span').remove();
				click.find('input').val('');
			if(response.status == 'success'){
			      swal("Success!",response.message, "success");
			}
			if(response.status == 'failed'){
			  swal("Failed!",response.message, "error");
			}
			if(response.status == 'error'){
				$.each(response.errors, function (key, val) {
				click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
				});
			}
		},
		'error' : function(error){
			console.log(error);
		},
		complete: function() {

		},
		});
	});

	  $('body').on('submit','#add-currency-form',function(e){
	  	e.preventDefault();
	    var click = $(this);
		let form  = $(this);
	    let data = form.serialize();
		$.ajax({
			"headers":{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		},
			'type':'POST',
			'url' : form.attr('action'),
			'data' : data,
		beforeSend: function() {

		},
		'success' : function(response){
				click.find('span').remove();
				click.find('input').val('');
			if(response.status == 'success'){
			      swal("Success!",response.message, "success");
   			      getCurrencies();
			}
			if(response.status == 'failed'){
			  swal("Failed!",response.message, "error");
			}
			if(response.status == 'error'){
				$.each(response.errors, function (key, val) {
				click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
				});
			}
		},
		'error' : function(error){
			console.log(error);
		},
		complete: function() {

		},
		});
	  });

	   $('body').on('submit','#dlt-currency-form',function(e){
	  	e.preventDefault();
	    var click = $(this);
		let form  = $(this);
	    let data = form.serialize();
		$.ajax({
			"headers":{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		},
			'type':'DELETE',
			'url' : form.attr('action'),
			'data' : data,
		beforeSend: function() {

		},
		'success' : function(response){
			if(response.status == 'success'){
			      swal("Success!",response.message, "success");
   			      getCurrencies();
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