<?php $__env->startSection('content'); ?>
	<div class="main-body">
					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
											<a href="<?php echo e(route('vendor.supplier.index')); ?>">Supplier List</a>
											<a href="javascript:void(0)">Supplier Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Supplier ID:#<?php echo e($user->supplier_id); ?></label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<div class="profile-details">
										<div class="profile-star clearfix">
											<div class="img">
												<img onerror="profileImgError(this)" src="<?php echo e($user->profile_image); ?>" class="img-responsive">
											</div>

											<div class="star">
												<h2><img class="betch" src="<?php echo e(asset('public')); ?>/images/betch.png"><?php if($user->is_verified == '1'): ?>  Verify supplier <?php else: ?> Unverified suppliser <?php endif; ?></h2>

												<div class="star-rating">
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
												</div>
											</div>
										</div>

										<div class="input-details">
											<div class="form-group">
												<p class="form-control"><?php echo e($user->name); ?></p>
											</div>
											<div class="form-group">
												<p class="form-control"><?php echo e($user->email); ?></p>
											</div>
											<div class="form-group">
												<p class="form-control"><?php echo e($user->phone); ?></p>
											</div>

											<h2 class="title">Other Details</h2>

											<div class="form-group">
												<p class="form-control"><?php echo e($user->business_name); ?></p>
											</div>
											<div class="form-group">
												<p class="form-control"><?php echo e($user->address); ?></p>
											</div>
										</div>

									</div>
								</div><!--END supplier profile-->

								<!--supplier documents-->
								<div class="col-md-5 col-sm-5 col-xs-12">
									<div class="supplier-documents">
										<h2>Business Details & Documents</h2>

										<div class="documents clearfix">
											<?php if($user->documents): ?>
												   <?php $__currentLoopData = $user->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<!--single-document-->
													<div class="single-document">
														<p>Registration No</p>
														<label class="img">
															<img src="<?php echo e($document->document); ?>">
														</label>
													</div><!--end-->
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</div>
									</div>
								</div><!--END supplier documents-->
							</div>
						</div><!--END supplier-details-->

					</div>	
				</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>