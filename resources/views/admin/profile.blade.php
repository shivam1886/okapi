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
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<form method="POST" action="{{ route('admin.profile.update') }}" id="update-profile-form" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT')}}
										<div class="profile-details">
											<div class="profile-star clearfix">
												<div class="img">
													<span class="edit"><i class="fas fa-pencil-alt"></i></span>
													<label>
															<img onerror="profileImgError(this)" src="{{$data['user']->profile_image}}" class="img-responsive image-preview">
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
													<input type="email" placeholder="Email" class="form-control" name="email" value="{{old('email') ?? $data['user']->email}}" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
														@if ($errors->has('email'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('email') }}</strong>
														</span>
													@endif
												</div>

												<h2 class="title">Other Details</h2>
										
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
							</div>
						</div><!--END supplier-details-->

					</div>	
				</div>
@endsection
@push('js')
  <script type="text/javascript">

  	  //Image Preview
	  $('input[name="profile_image"]').on('change',function(e){
	   	  tmppath = URL.createObjectURL(event.target.files[0]);
		  $('.image-preview').attr('src',tmppath);
	  });

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

  </script>
@endpush