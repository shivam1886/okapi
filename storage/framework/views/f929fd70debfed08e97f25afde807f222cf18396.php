<?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="gst add-tax">
		<form action="<?php echo e(route('supplier.remove.tax')); ?>" method="post" id="add-tax-form" class="remove-tax-form">
			<?php echo csrf_field(); ?>
			<?php echo e(method_field('DELETE')); ?>

			<input type="hidden" name="id" value="<?php echo e($tax->id); ?>">
			<input class="tax" type="text" placeholder="title" value="<?php echo e($tax->title); ?>" name="title" disabled>
			<input class="percentage" type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" placeholder="tax" value="<?php echo e($tax->tax); ?>" name="tax" disabled>
			<button style="background: #e45a63"><i class="fas fa-trash"></i></button>
		</form>
	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>