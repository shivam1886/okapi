<?php $__env->startSection('content'); ?>
	<div class="main-body">
					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation"><a href="<?php echo e(route('vendor.tendor.index')); ?>">My Tenders</a><a href="javascript:void(0)">Tendor Details</a></p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="btns">
										<a  href="<?php echo e(route('vendor.tendor.edit',$data['tendor']->id)); ?>" class="edit-tender">Edit Tenders</a>
									    <button class="delete-tender">Delete Tenders</button>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tender-details">
							<!--id-date-->
							<div class="id-date">
								<label class="id">Tender ID:#<?php echo e($data['tendor']->id); ?></label>
								<label class="p-date"><i class="far fa-calendar-alt"></i> <span>Publish Date:</span><?php echo e(date('d-m-Y',strtotime($data['tendor']->created_at))); ?></label>
								<label class="close-date">Close Date: <?php echo e(date('d-m-Y',strtotime($data['tendor']->created_at . '+' .$data['tendor']->day. 'days'))); ?></label>
							</div><!--END id-date-->

												<?php $__currentLoopData = $data['tendor']->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                        <!--product-details-->
							<div class="product-details">
								<div class="single-p-details">
									<div class="table-responsive">
										<table>
											<thead>
												<tr>
													<td>Product Name</td>
													<td>Product Qty</td>
													<td>Unit</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo e($product->title); ?></td>
													<td><?php echo e($product->qty); ?></td>
													<td><?php echo e($product->unit); ?></td>
												</tr>
											</tbody>
										</table>
										<div class="discription">
											<p><?php echo e($product->description); ?></p>
										</div>
									</div>
								</div>
							</div><!--END product-details-->
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<!--Data table-->
							<div class="custom-data-table">
								<div class="data-table">
									<div class="heading-search">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<h2>Total Entries: <?php echo e(count($data['suppliers'])); ?></h2>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
											
											</div>
										</div>
									</div>
									<div class="custom-table-height">
										<div class="table-responsive">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>Suplier Name</th>
														<th>Verify Suplier</th>
														<th>Phone Number </th>
														<th>Address</th>
														<th>Submit Quotation</th>
														<th>Total Amount </th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $__currentLoopData = $data['suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<!--single table row-->
														<tr>
															<td><?php echo e($supplier['name']); ?></td>
															<td> <img class="betch" src="<?php echo e(asset('public/')); ?>/images/betch.png"> <span class="verify"><?php echo e($supplier['is_verified'] == '1' ? 'Verify Supplier' : 'Not Verify'); ?></span> </td>
															<td><?php echo e($supplier['phone']); ?></td>
															<td><?php echo e($supplier['address']); ?></td>
															<td><?php echo e($supplier['is_submit_quotation'] == 1 ? 'Yes' : 'No'); ?></td>
															<td><?php echo e($data['tendor']->currency); ?> <?php echo e(number_format($supplier['amount'],2)); ?></td>
															<td>
																<?php if($supplier['is_submit_quotation']): ?>
																     <a class="details" data-toggle="tooltip" href="<?php echo e(route('vendor.quotation.details',$supplier['quotation_id'])); ?>">Details</a>
																<?php else: ?>
																     <a  data-toggle="tooltip" title="Supplier not Submitted quotation yet" class="details" href="javascript:void()" disabled>Details</a>
																<?php endif; ?>
															</td>
														</tr> <!--end-->
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>
											</table>
										</div>
									</div>

									<!-- <div class="t-pagination clearfix">
										<div class="text-result">
											<p>Showing 1 to 1 of 1 entries</p>
										</div>
										<div class="pagination-no">
											<ul>
												<li><button>Previous</button></li>
												<li><span class="active">1</span></li>
												<li><span>2</span></li>
												<li><button>Next</button></li>
											</ul>
										</div>
									</div> -->
								</div>
							</div><!--END Data table-->
						</div><!--END my tenders-->

					</div>	
				</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
 <script type="text/javascript">
 	$('.delete-tender').on('click',function(e){
       	  e.preventDefault();

       	  	 swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this tendor!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		 })
		 .then((willDelete) => {
				if(!willDelete){
				   return false;
				}

				let data = {'id':"<?php echo e($data['tendor']->id); ?>"};
				$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
				},
				'type':'DELETE',
				'url' : "<?php echo e(route('vendor.tendor.delete')); ?>",
				'data' : data,
				beforeSend: function() {

				},
				'success' : function(response){
				if(response.status == 'success'){
					 swal("Success!",response.message, "success");
					 setTimeout(function(){ window.location.href = "<?php echo e(route('vendor.tendor.index')); ?>" }, 2000);
				}
				if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
				}
				if(response.status == 'error'){
				     console.log(response.errors);
				}
				},
				'error' : function(error){
				console.log(error);
				},
				complete: function() {

				},
				});
          });
 	});
 </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>