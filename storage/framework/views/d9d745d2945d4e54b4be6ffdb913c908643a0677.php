<?php $__env->startSection('content'); ?>
    <div class="main-body">

          <div class="inner-body">
            <!--header-->
            <div class="header">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="title">
                    <h2>Supplier List</h2>
                  </div>
                </div>
              </div>
            </div><!--END header-->

            <!--my tenders-->
            <div class="supplier-request">
              <div class="row">
                <?php $__currentLoopData = $data['suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--single-s-request-->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="single-s-request">
                    <div class="img-text clearfix">
                      <div class="img">
                           <img src="<?php echo e($supplier->profile_image); ?>" onerror="profileImgError(this)">
                      </div>
                      <div class="txt">
                         <h2><?php echo e($supplier->name); ?></h2>
                         <p><i class="fas fa-map-marker-alt"></i><?php echo e($supplier->address); ?></p>
                      </div>
                    </div>
                	<div class="buttons txt">
                        <a href="<?php echo e(route('admin.supplier.details',$supplier->id)); ?>">Details</a>
					</div>
                  </div>
                </div><!--END single-s-request-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div><!--END my tenders-->

          </div>  
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>