<?php $__env->startSection('content'); ?>
<div class="main-body">

		 <!-----START searching box--------->
					<section class="searching-filter">
						<form method="GET">
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-md-4">
											<div class="input">
												<input type="text" placeholder="Search by business name" name="search" value="<?php echo e(Request::get('search')); ?>">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
												<input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Day" name="day" value="<?php echo e(Request::get('day')); ?>">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
											     <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Month" name="month" value="<?php echo e(Request::get('month')); ?>">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
											     <input type="year" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Year" name="year" value="<?php echo e(Request::get('year')); ?>">
											</div>
										</div>
										<div class="col-md-2">
											<div class="filter-btn">
                                               <select name="status">
                                               	 <option value="">--All-</option>
                                               	 <option <?php if(Request::get('status') == '1'): ?> selected <?php endif; ?> value="1">Processing</option>
                                               	 <option <?php if(Request::get('status') == '2'): ?> selected <?php endif; ?> value="2">Dispatch</option>
                                               	 <option <?php if(Request::get('status') == '3'): ?> selected <?php endif; ?> value="3">Delivered</option>
                                               	 <option <?php if(Request::get('status') == '4'): ?> selected <?php endif; ?> value="4">Cancel</option>
                                               </select>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3 col-xs-3">
									<div class="filter-btn">
										<a class="button" href="<?php echo e(route('supplier.order.index')); ?>">Clear</a>
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
										<h2>My Orders</h2>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tenders my-orders">
							<div class="row">
								<?php $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<!--single-tender-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo e(route('supplier.order.show',$order->id)); ?>">
											<div class="single-tender">
											<div class="heading">
												<h2><?php echo e($order->vendor->business_name); ?></h2>
												<p class="address"><i class="fas fa-map-marker-alt"></i> &nbsp;<?php echo e($order->vendor->address); ?></p>
												<p>
													<i class="far fa-calendar-alt"></i> <span>Order Date</span><?php echo e(date('d-M-Y',strtotime($order->created_at))); ?></p>
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
															<?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<tr>
																	<td><?php echo e($item->title); ?></td>
																	<td><?php echo e($item->supply_qty); ?> <?php echo e($item->unit); ?></td>
																</tr>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</tbody>
														<tfoot>
															<tr>
																<td>
																	Status:
																	<?php if($order->status == '1'): ?>
																	   <span class="recived" style="color:orange">Processing</span>
																	<?php elseif($order->status == '2'): ?>
																	    <span class="recived">Dispatch</span>
																	<?php elseif($order->status == '3'): ?>
																	    <span class="recived" style="color:green">Delivered</span>
																	<?php elseif($order->status == '4'): ?>
    																	<span class="recived" style="color:red">Cancelled</span>
    																<?php else: ?>
    																    <span class="recived">Pending</span>
																	<?php endif; ?>
																</td>
																<td>
																	<i class="far fa-clock"></i>
																	Lead Time:
																	<span>10 Days</span>
																</td>
															</tr>
														</tfoot>
													</table>
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