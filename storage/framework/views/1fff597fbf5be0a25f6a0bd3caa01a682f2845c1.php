<?php $__currentLoopData = $data['currency']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="gst add-tax">
		<form action="<?php echo e(route('vendor.currency.destroy',$currency->id)); ?>" method="post" id="dlt-currency-form">
			<?php echo csrf_field(); ?>
			<?php echo e(method_field('DELETE')); ?>

			<input class="tax" type="text" placeholder="currency" value="<?php echo e($currency->title); ?>" name="currency" readonly>
			<button style="background: #e45863"><i class="fas fa-trash"></i></button>
		</form>
	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>