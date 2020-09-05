<?php $__env->startSection('content'); ?>
				<div class="main-body">

					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
											<a href="<?php echo e(route('supplier.my.vendor')); ?>">Close Vendor List</a>
											<a href="<?php echo e(route('supplier.my.vendor.details',$data['vendor']->id)); ?>"> Details</a>
										</p>
									</div>
								</div>
								<!-- <div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Tender ID:#1225223</label>
									</div>
								</div> -->
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
												<img onerror="profileImgError(this)" src="<?php echo e($data['vendor']->profile_image); ?>" class="img-responsive">
											</div>

											<div class="star">
												<button class="remove-btn remove" data-url="<?php echo e(route('supplier.vendor.remove',$data['vendor']->id)); ?>">Remove</button>
											</div>
										</div>

										<div class="input-details">
											<div class="form-group">
												<input class="form-control" type="text" placeholder="Title" name="" value="<?php echo e($data['vendor']->title); ?>" readonly>
											</div>
											<div class="form-group">
												<input class="form-control" type="text" placeholder="Name" name="" value="<?php echo e($data['vendor']->name); ?>" readonly>
											</div>
											<div class="form-group">
												<input type="email" value="<?php echo e($data['vendor']->email); ?>" placeholder="Email" class="form-control" name="" readonly>
											</div>
											<div class="form-group">
												<input type="text" value="<?php echo e($data['vendor']->phone); ?>" placeholder="Number" class="form-control" name="" readonly>
											</div>

											<h2 class="title">Other Details</h2>

											<div class="form-group">
												<input type="text" value="<?php echo e($data['vendor']->business_name); ?>" class="form-control" placeholder="Business Name" name="" readonly>
											</div>
											<div class="form-group">
												<textarea rows="" class="form-control" placeholder="Address" readonly><?php echo e($data['vendor']->address); ?></textarea>
											</div>

											<div class="row">
												<div class="col-md-4 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" value="<?php echo e($data['vendor']->city); ?>" class="form-control" placeholder="City" name="" readonly>
													</div>
												</div>
												<div class="col-md-4 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" value="<?php echo e($data['vendor']->state); ?>" class="form-control" placeholder="State" name="" readonly>
													</div>
												</div>
												<div class="col-md-4 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" value="<?php echo e($data['vendor']->country); ?>" class="form-control" placeholder="Country" name="" readonly>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div><!--END supplier profile-->

								<!--supplier documents-->
								<div class="col-md-5 col-sm-5 col-xs-12">
									<div class="supplier-documents">

										<?php $__currentLoopData = $data['vendor']->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<!--single-department-->
										<div class="single-department">
											<div class="form-group">
												<label>Department Name</label>
												<p><?php echo e($department->name); ?></p>
											</div>

											<div class="form-group">
												<label>Contact Number</label>
												<p><?php echo e($department->phone); ?></p>
											</div>

											<div class="form-group">
												<label>Email Address</label>
												<p><?php echo e($department->email); ?></p>
											</div>
										</div><!--end single-department-->
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div><!--END supplier documents-->

							</div>
						</div><!--END supplier-details-->
					</div>
				</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
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
                  setTimeout(function(e){ window.location.href = "<?php echo e(route('supplier.my.vendor')); ?>" },1000); 
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