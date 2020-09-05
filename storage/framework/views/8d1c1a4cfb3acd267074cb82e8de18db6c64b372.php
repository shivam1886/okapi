 <?php if(Session::get('message')): ?>
  <div class="alert <?php if(Session::get('status')): ?> <?php echo e('alert-success'); ?> <?php else: ?> <?php echo e('alert-danger'); ?> <?php endif; ?>" role="alert">
    <i class="fa <?php if(Session::get('status')): ?> fa-check <?php else: ?> fa-times <?php endif; ?> mx-2"></i>
    <?php echo e(Session::get('message')); ?>

 </div>
 <?php endif; ?>