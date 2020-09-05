	<?php $__currentLoopData = $data['requests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<!--single-s-request-->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="single-s-request">
			<div class="img-text clearfix">
				<div class="img">
					<img onerror="profileImgError(this)" src="<?php echo e($request->user->profile_image); ?>">
				</div>
				<div class="txt">
					<h2><?php echo e($request->user->business_name); ?></h2>
					<p><i class="fas fa-map-marker-alt"></i><?php echo e($request->user->address); ?></p>
				</div>
			</div>
			<div class="buttons">
				<button data-id="<?php echo e($request->id); ?>" class="accept">Accept</button>
			    <button data-id="<?php echo e($request->id); ?>" class="remove">Decline</button>
				<a href="<?php echo e(route('vendor.supplier.show',$request->supplier_id)); ?>" class="details">Details</a>
			</div>
		</div>
	</div><!--END single-s-request-->
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>