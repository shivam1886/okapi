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
										<a class="button" href="<?php echo e(route('supplier.quotation.index')); ?>">Clear</a>
										<button class="button" type="submit">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</section>
					<!-----END searching box--------->

					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="title">
										<h2>My Quotation</h2>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tenders">
							<div class="row">
								<?php $__currentLoopData = $data['quotations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<!--single-tender-->
								<div class="col-md-6 col-sm-6 col-xs-12">
									<a href="<?php echo e(route('supplier.quotation.show',$quotation->id)); ?>">
										<div class="single-tender">
											<div class="heading">
												<h2><?php echo e($quotation->tendor->user->business_name); ?></h2>
												<p class="address"><i class="fas fa-map-marker-alt"></i> &nbsp; <?php echo e($quotation->tendor->user->address); ?></p>
											</div>

											<div class="body">
												<div class="table-responsive">
													<table>
														<thead>
															<tr>
																<td>Product Name</td>
																<td>Quantity</td>
															</tr>
														</thead>
														<tbody>
								                           <?php $__currentLoopData = $quotation->tendor->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<tr>
																	<td><?php echo e($product->title); ?></td>
																	<td><?php echo e($product->qty); ?> <?php echo e($product->unit); ?></td>
																</tr>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</tbody>
													</table>
												</div>
												<div class="submit-mg">
													<p>
														<img src="<?php echo e(asset('public')); ?>/images/right1.png">
														Your Quotation is successfully Submit
													</p>
												</div>
												<div class="date-total">
													<label class="close-date">Close Date: <?php echo e(date('d-m-Y',strtotime($quotation->tendor->created_at . '+'.$quotation->tendor->day.' days'))); ?></label>
												</div>
											</div>										
										</div>
									</a>
								</div><!--END single-tender-->
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div><!--END my tenders-->

					</div>	
				</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>