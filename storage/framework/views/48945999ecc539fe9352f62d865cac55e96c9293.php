<?php $__env->startSection('content'); ?>
                 <div class="main-body">

                 		<!-----START searching box--------->
					<section class="searching-filter">
						<form method="GET">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="row">
										<div class="col-md-12">
											<div class="input">
												<input type="text" placeholder="Search by business name" name="search" value="<?php echo e(Request::get('search')); ?>">
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="filter-btn">
										<a class="button" href="<?php echo e(route('supplier.vendor.index')); ?>">Clear</a>
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
								
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="supplier-request market-place">
							<div class="row">
								<?php $__empty_1 = true; $__currentLoopData = $data['vendors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<!--single-s-request-->
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="single-s-request">
										<div class="img-text clearfix">
											<div class="img">
												<img onerror="profileImgError(this)" src="<?php echo e($vendor->profile_image); ?>">
											</div>
											<div class="txt">
												<h2><?php echo e($vendor->business_name); ?></h2>
												<p><i class="fas fa-map-marker-alt"></i><?php echo e($vendor->address); ?></p>
												
											</div>
										</div>
										<div class="buttons txt">
											<?php if($vendor->is_request): ?>
                                                <button class="cancel-request-btn remove" data-url="<?php echo e(route('supplier.cancel.request',$vendor->id)); ?>">Cancel Request</button>
                                            <?php else: ?>
                                                <button class="request-btn" data-url="<?php echo e(route('supplier.vendor.request',$vendor->id)); ?>">Request</button>
                                            <?php endif; ?>
                                           <a href="<?php echo e(route('supplier.vendor.show',$vendor->id)); ?>">Details</a>
										</div>
									</div>
								</div><!--END single-s-request-->
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
								<?php endif; ?>
							</div>
						</div><!--END my tenders-->

					</div>	
				</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
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
                  setTimeout(function(e){ window.location.href = "<?php echo e(route('supplier.vendor.index')); ?>" },2000); 
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
                  setTimeout(function(e){ window.location.href = "<?php echo e(route('supplier.vendor.index')); ?>" },2000); 
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