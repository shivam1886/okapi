<?php $__env->startSection('content'); ?>
<div class="main-body">
					<div class="header-banner" style="background-image: url('<?php echo e(asset('public')); ?>/images/banner.jpg');">
						<div class="txt-wrapper">
							<div class="txt">
								<h2>Publishing and graphic design, Lorem ipsum is a placeholder text commonly used to </h2>
								<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a </p>
							</div>
						</div>
					</div>

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
										<a class="button" href="<?php echo e(route('supplier.tendor.index')); ?>">Clear</a>
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
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<h2>Explore Tenders</h2>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
							
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tenders">
							<div class="row">
								<?php $__currentLoopData = $data['tendors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<!--single-tender-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo e(route('supplier.tendor.show',$tendor->id)); ?>">
											<div class="single-tender">
												<div class="heading">
													<h2><?php echo e($tendor->user->business_name); ?></h2>
													<p class="address"><i class="fas fa-map-marker-alt"></i> &nbsp; <?php echo e($tendor->user->address); ?></p>
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
																<?php if($tendor): ?>
																	<?php $__empty_1 = true; $__currentLoopData = $tendor->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
																	<tr>
																		<td><?php echo e($product->title); ?></td>
																		<td><?php echo e($product->qty); ?> <?php echo e($product->unit); ?></td>
																	</tr>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
																<?php endif; ?>
																</tbody>
															</table>
														<?php endif; ?>
													</div>
													<div class="date-total">
														<label class="close-date">Close Date: <?php echo e(date('d-m-Y',strtotime($tendor->created_at . '+'.$tendor->day.' days'))); ?></label>
													</div>
												</div>

												<span class="arrow"><i class="fas fa-arrow-right"></i></span>
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