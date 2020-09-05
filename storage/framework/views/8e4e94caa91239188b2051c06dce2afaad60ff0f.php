<?php $__currentLoopData = $data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--single-->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="single-pc" data-id="<?php echo e($product->id); ?>">
			<h2><?php echo e($product->title); ?></h2>
			<div class="price">
				<p>Price: <span><?php echo e($product->currency); ?> <?php echo e($product->price); ?></span></p>
			</div>
		</div>
	</div><!--END-->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>