<?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--single-document-->
<div class="single-document">
	<p>&nbsp;</p>
	<label class="img">
		<input type="file">
		<img src="<?php echo e($document->document); ?>">
	</label>
</div><!--end-->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>