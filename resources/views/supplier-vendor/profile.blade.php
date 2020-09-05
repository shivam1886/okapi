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
											<form action="{{route('supplier.add.tax')}}" method="post" id="add-tax-form">
												@csrf
												<input class="tax" type="text" placeholder="title" value="" name="title" required>
												<input class="percentage" type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" placeholder="tax" value="" name="tax" required>
												<button><i class="fas fa-plus"></i></button>
											</form>
										</div>
									</div>

									<div class="supplier-documents">
                                        <div class="departments-list">
											@foreach($data['departments'] as $Key => $department)
												<!--single-department-->
												<div class="single-department">
													<div class="edit-dlt">
														<button class="blt-btn" data-id="{{$department->id}}"><i class="fas fa-trash"></i></button>
														<button><i class="fas fa-pen btn-edit"></i></button>
													</div>
											<form method="POST" action="{{ route('vendor.department.update') }}" class="update-department-form">
												@csrf
												{{method_field('PUT')}}
												<input type="hidden" name="department_id" value="{{$department->id}}">
													<div class="form-group">
														<label>Department Name</label>
														<input type="text" disabled placeholder="Department Name" value="{{$department->name}}" name="department_name" required>
													</div>

													<div class="form-group">
														<label>Contact Number</label>
														<input type="text" disabled placeholder="Contact Number" value="{{$department->phone}}" name="department_phone" required>
													</div>

													<div class="form-group">
														<label>Email Address</label>
														<input type="text" disabled placeholder="Email Address" value="{{$department->email}}" name="department_email" required>
													</div>
													<div class="add-btn update-department-btn">
													   <button>Update Department</button>
													</div>
											</form>
												</div><!--end single-department-->
											@endforeach
                                        </div>

										<!--single-department-->
										<div class="single-department add-department">
											<form method="POST" action="{{route('vendor.department.create')}}" id="add-department-form">
                                             @csrf
											<div class="form-group">
												<label>Department Name</label>
												<input type="text" placeholder="Department Name" value="{{old('department_name')}}" name="department_name" class="{{ $errors->has('department_name') ? ' is-invalid' : '' }}" value="{{ old('department_name') }}" required>
												@if ($errors->has('department_name'))
													<span class="invalid-feedback" role="alert">
													    <strong>{{ $errors->first('department_name') }}</strong>
													</span>
												@endif
											</div>

											<div class="form-group">
												<label>Contact Number</label>
												<input type="text" placeholder="Contact Number" value="{{old('department_phone')}}" name="department_phone" class="{{ $errors->has('department_phone') ? ' is-invalid' : '' }}" value="{{ old('department_phone') }}" required>
												@if ($errors->has('department_phone'))
													<span class="invalid-feedback" role="alert">
													    <strong>{{ $errors->first('department_phone') }}</strong>
													</span>
												@endif
											</div>

											<div class="form-group">
												<label>Email Address</label>
												<input type="text" placeholder="Email Address" name="department_email" value="{{old('department_email')}}" name="department_email" class="{{ $errors->has('department_email') ? ' is-invalid' : '' }}" value="{{ old('department_email') }}" required>
												@if ($errors->has('department_email'))
													<span class="invalid-feedback" role="alert">
													    <strong>{{ $errors->first('department_email') }}</strong>
													</span>
												@endif
											</div>
												<div class="add-btn">
													<button>Add Department</button>
												</div>
											</form>
										</div><!--end-->

									</div>
									
								</div><!--END supplier documents-->

							</div>
						</div><!--END supplier-details-->

					</div>	
				</div>
@endsection
@push('js')
  <script type="text/javascript">
      
      $('#document-update-form button').hide();

  	  $('body').on('submit','#add-tax-form',function(e){
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

// Hide all department update btn
  	$('.update-department-btn').hide();

  	   // Get Departments
  	    var getDepartments = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "{{route('vendor.department.list')}}",
					beforeSend: function() {

					},
					'success' : function(response){
              	        $('.departments-list').html(response);
					},
  					'error' : function(error){
					},
					complete: function() {
					},
					});
  	    }
  	 
  	 // Departmetn remove confirmation modal
  	 $('body').on('click','.blt-btn',function(e){
  	 	 swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this department file!",
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
					'type':'DELETE',
					'url' : '{{route('vendor.department.delete')}}',
					'data' : {id},
				beforeSend: function() {
				},
				'success' : function(response){
					if(response.status == 'success'){
						swal("Success!",response.message, "success");
					    getDepartments();
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
     $('#add-department-form').on('submit',function(e){
         e.preventDefault();
         var click = $(this);
         let form = $(this);
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
        	click.find('input').val('');
			click.find('span').hide();
          	if(response.status == 'success'){
 				 swal("Success!",response.message, "success");
             	 getDepartments();
          	}
          	if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
          	}
        	if(response.status == 'error'){
				$.each(response.errors, function (key, val) {
				click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
				$('.'+key).after('<br><span style="color:red">'+val+'</span>');
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

     $('body').on('click','.btn-edit',function(e){
       	  $(this).toggleClass('fa-times');
       	  if($(this).hasClass('fa-times'))
        	  $(this).parents('.single-department').find('input').removeAttr('disabled');
          else{
          	  $(this).parents('.single-department').find('form')[0].reset();
    	      $(this).parents('.single-department').find('input').attr('disabled',true);
          }
       	  $(this).parents('.single-department').find('.update-department-btn').toggle();
     });

     $('body').on('submit','.update-department-form',function(e){
       	  e.preventDefault();
       	  var click = $(this);
       	  let form = $(this);
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
 				 swal("Success!",response.message, "success");
 				 getDepartments();
          	}
          	if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
          	}
        	$('#add-department-form input').val('');
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

  </script>
@endpush