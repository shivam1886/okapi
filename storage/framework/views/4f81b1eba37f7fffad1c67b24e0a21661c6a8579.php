<?php $__env->startSection('content'); ?>
<div class="main-body">
<?php echo $__env->make('common.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
										<label class="id">Account ID: #<?php echo e(auth::id()); ?></label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<form method="POST" action="<?php echo e(route('vendor.update.profile')); ?>" id="update-profile-form" enctype="multipart/form-data" autocomplete="on">
                                        <?php echo csrf_field(); ?>
                                        <?php echo e(method_field('PUT')); ?>

										<div class="profile-details">
											<div class="profile-star clearfix">
												<div class="img">
													<span class="edit"><i class="fas fa-pencil-alt"></i></span>
													<label>
															<img onerror="profileImgError(this)" src="<?php echo e($data['user']->profile_image); ?>" class="img-responsive image-preview">
															<input type="file" name="profile_image" accept="image/*">
													</label>
												</div>

												<div class="star">
													<button type="submit">Save Profile</button>
												</div>
											</div>
											<div class="input-details">
												<div class="form-group">
												<input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo e(old('name') ?? $data['user']->name); ?>" class="<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('name')); ?>">
													<?php if($errors->has('name')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('name')); ?></strong>
														</span>
													<?php endif; ?>
												</div>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Title" name="title" value="<?php echo e(old('title') ?? $data['user']->title); ?>" class="<?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('title')); ?>">
														<?php if($errors->has('title')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('title')); ?></strong>
														</span>
													<?php endif; ?>
												</div>
												<div class="form-group">
													<input type="email" placeholder="Email" class="form-control" name="email" value="<?php echo e(old('email') ?? $data['user']->email); ?>" class="<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>">
														<?php if($errors->has('email')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('email')); ?></strong>
														</span>
													<?php endif; ?>
												</div>
												<div class="form-group">
													<input type="text" placeholder="Number" class="form-control" name="phone" value="<?php echo e(old('phone') ?? $data['user']->phone); ?>" class="<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('phone')); ?>">
														<?php if($errors->has('phone')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('phone')); ?></strong>
														</span>
													<?php endif; ?>
												</div>

												<h2 class="title">Other Details</h2>

												<div class="form-group">
													<input type="text" class="form-control" placeholder="Business Name" name="business_name" value="<?php echo e(old('business_name') ?? $data['user']->business_name); ?>" class="<?php echo e($errors->has('business_name') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('business_name')); ?>">
														<?php if($errors->has('business_name')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('business_name')); ?></strong>
														</span>
													<?php endif; ?>
												</div>
												<div class="form-group">
													<textarea rows="" class="form-control" id="address" name="address" placeholder="Address" class="<?php echo e($errors->has('address') ? ' is-invalid' : ''); ?>" autocomplete="off"><?php echo e(old('address') ?? $data['user']->address); ?></textarea>
														<input type="hidden" value="<?php echo e($data['user']->latitude); ?>" name="latitude"  id="latitude" name="">
														<input type="hidden" value="<?php echo e($data['user']->longitude); ?>" name="longitude" id="longitude" name="">
														<?php if($errors->has('address')): ?>
															<span class="invalid-feedback" role="alert">
															   <strong><?php echo e($errors->first('address')); ?></strong>
															</span>
													    <?php endif; ?>
												</div>

												<div class="row">
													<div class="col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="City" name="city" value="<?php echo e(old('city') ?? $data['user']->city); ?>" class="<?php echo e($errors->has('city') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('city')); ?>">
																<?php if($errors->has('city')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('city')); ?></strong>
														</span>
													<?php endif; ?>
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="State" name="state" value="<?php echo e(old('state') ?? $data['user']->state); ?>" class="<?php echo e($errors->has('state') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('state')); ?>">
																<?php if($errors->has('state')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('state')); ?></strong>
														</span>
													<?php endif; ?>
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<input type="text" class="form-control" placeholder="Country" name="country" <?php echo e(old('country') ?? $data['user']->country); ?> class="<?php echo e($errors->has('country') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('country') ?? $data['user']->country); ?>">
																<?php if($errors->has('country')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('country')); ?></strong>
														</span>
													<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
								    </form>

								    <!--change pass-->
									<div class="supplier-documents">
								 		<form method="POST" action="<?php echo e(route('change.password')); ?>" id="change-password">
								 			<?php echo csrf_field(); ?>
								 			<?php echo e(method_field('PUT')); ?>

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
									<div class="supplier-documents">
                                        <div class="departments-list">
											<?php $__currentLoopData = $data['departments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Key => $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<!--single-department-->
												<div class="single-department">
													<div class="edit-dlt">
														<button class="blt-btn" data-id="<?php echo e($department->id); ?>"><i class="fas fa-trash"></i></button>
														<button><i class="fas fa-pen btn-edit"></i></button>
													</div>
											<form method="POST" action="<?php echo e(route('vendor.department.update')); ?>" class="update-department-form">
												<?php echo csrf_field(); ?>
												<?php echo e(method_field('PUT')); ?>

												<input type="hidden" name="department_id" value="<?php echo e($department->id); ?>">
													<div class="form-group">
														<label>Department Name</label>
														<input type="text" disabled placeholder="Department Name" value="<?php echo e($department->name); ?>" name="department_name" required>
													</div>

													<div class="form-group">
														<label>Contact Number</label>
														<input type="text" disabled placeholder="Contact Number" value="<?php echo e($department->phone); ?>" name="department_phone" required>
													</div>

													<div class="form-group">
														<label>Email Address</label>
														<input type="text" disabled placeholder="Email Address" value="<?php echo e($department->email); ?>" name="department_email" required>
													</div>
													<div class="add-btn update-department-btn">
													   <button>Update Department</button>
													</div>
											</form>
												</div><!--end single-department-->
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

										<!--single-department-->
										<div class="single-department add-department">
											<form method="POST" action="<?php echo e(route('vendor.department.create')); ?>" id="add-department-form">
                                             <?php echo csrf_field(); ?>
											<div class="form-group">
												<label>Department Name</label>
												<input type="text" placeholder="Department Name" value="<?php echo e(old('department_name')); ?>" name="department_name" class="<?php echo e($errors->has('department_name') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('department_name')); ?>" required>
												<?php if($errors->has('department_name')): ?>
													<span class="invalid-feedback" role="alert">
													    <strong><?php echo e($errors->first('department_name')); ?></strong>
													</span>
												<?php endif; ?>
											</div>

											<div class="form-group">
												<label>Contact Number</label>
												<input type="text" placeholder="Contact Number" value="<?php echo e(old('department_phone')); ?>" name="department_phone" class="<?php echo e($errors->has('department_phone') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('department_phone')); ?>" required>
												<?php if($errors->has('department_phone')): ?>
													<span class="invalid-feedback" role="alert">
													    <strong><?php echo e($errors->first('department_phone')); ?></strong>
													</span>
												<?php endif; ?>
											</div>

											<div class="form-group">
												<label>Email Address</label>
												<input type="text" placeholder="Email Address" name="department_email" value="<?php echo e(old('department_email')); ?>" name="department_email" class="<?php echo e($errors->has('department_email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('department_email')); ?>" required>
												<?php if($errors->has('department_email')): ?>
													<span class="invalid-feedback" role="alert">
													    <strong><?php echo e($errors->first('department_email')); ?></strong>
													</span>
												<?php endif; ?>
											</div>
												<div class="add-btn">
													<button>Add Department</button>
												</div>
											</form>
										</div><!--end-->
									</div>
									<!--added-tax-->
									<div class="added-tax">
										<span>Added Currency</span><br>
										<div class="currency-list">
											<?php $__currentLoopData = $data['user']->currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="gst add-tax">
												<form action="<?php echo e(route('vendor.currency.destroy',$currency->id)); ?>" method="post" id="dlt-currency-form">
												<?php echo csrf_field(); ?>
												<?php echo e(method_field('DELETE')); ?>

												<input class="tax" type="text" placeholder="currency" value="<?php echo e($currency->title); ?>" name="currency" readonly>
												<button style="background: #e45863"><i class="fas fa-trash"></i></button>
												</form>
											</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</div>
										<div class="gst add-tax">
											<form action="<?php echo e(route('vendor.currency.create')); ?>" method="post" id="add-currency-form">
												<?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
  <script type="text/javascript">

  	  	 // store or update clinic
     $('#update-profile-form').on('submit',function(e){
			e.preventDefault();
			var  click = $(this);
			let form = $(this);
 		    let data = new FormData(this);
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
					click.find('input[name='+key+']').after('<span style="color:red">'+val+'</span>');
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
						'url' : "<?php echo e(route('vendor.department.list')); ?>",
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

  	     // Get Currencys
  	    var getCurrencies = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "<?php echo e(route('vendor.currency.list')); ?>",
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
					'url' : '<?php echo e(route('vendor.department.delete')); ?>',
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

     //Image Preview
	 $('input[name="profile_image"]').on('change',function(e){
			tmppath = URL.createObjectURL(event.target.files[0]);
		    $('.image-preview').attr('src',tmppath);
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>