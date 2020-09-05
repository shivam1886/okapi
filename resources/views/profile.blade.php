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
										<label class="id">Vender ID: #{{auth::id()}}</label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<form method="POST" action="{{ route('update.profile') }}" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT')}}
										<div class="profile-details">
											<div class="profile-star clearfix">
												<div class="img">
													<img src="images/01.jpg" class="img-responsive">
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
													<textarea rows="" class="form-control" name="address" placeholder="Address" class="{{ $errors->has('address') ? ' is-invalid' : '' }}">{{old('address') ?? $data['user']->address}}</textarea>
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
									<div class="supplier-documents">
                                        <div class="departments-list">
											@foreach($data['departments'] as $Key => $department)
											<!--single-department-->
											<div class="single-department">
												<div class="edit-dlt">
													<button class="blt-btn" data-id="{{$department->id}}"><i class="fas fa-trash"></i></button>
													<button><i class="fas fa-pen"></i></button>
												</div>
												<div class="form-group">
													<label>Department Name</label>
													<input type="text" disabled placeholder="Department Name" value="{{$department->name}}" name="">
												</div>

												<div class="form-group">
													<label>Contact Number</label>
													<input type="text" disabled placeholder="Contact Number" value="{{$department->phone}}" name="">
												</div>

												<div class="form-group">
													<label>Email Address</label>
													<input type="text" disabled placeholder="Email Address" value="{{$department->email}}" name="">
												</div>
											</div><!--end single-department-->
											@endforeach
                                        </div>

										<!--single-department-->
										<div class="single-department add-department">
											<form method="POST" action="{{ route('department.create') }}" id="add-department-form">
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

  	   // Get Departments
  	    var getDepartments = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "{{route('department.list')}}",
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
					'url' : '{{route('department.delete')}}',
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
     $('#update-profile-form').on('submit',function(e){
			e.preventDefault();
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
				if(response.status == 'success'){
				  swal("Success!",response.message, "success");
				  getDepartments();
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

  	 // store or update clinic
       $('#add-department-form').on('submit',function(e){
         e.preventDefault();
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
          	if(response.status == 'success'){
 				 swal("Success!",response.message, "success");
             	 getDepartments();
          	}
          	if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
          	}
        	$('#add-department-form input').val('');
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