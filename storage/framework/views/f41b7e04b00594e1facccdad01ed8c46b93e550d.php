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
											<a href="<?php echo e(route('vendor.tendor.index')); ?>">My Tenders</a>
											<a href="<?php echo e(route('vendor.tendor.show',$data['quotation']->tendor_id)); ?>">Tenders details</a>
											<a href="<?php echo e(route('vendor.quotation.details',$data['quotation']->id)); ?>">quatation details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Tender ID:#<?php echo e($data['quotation']->tendor_id); ?></label>
									</div>
									<div class="text">
										<a href="<?php echo e(route('vendor.quotation.pdf',$data['quotation']->id)); ?>" class="download-pdf"><i class="fas fa-download"></i> Download PDF</a>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tender-details quatation-details">

							<!--tabs pills-->
							<div class="quatation-supplier-tabs">
								<ul class="nav nav-tabs">
								    <li class="active"><a data-toggle="tab" href="#QuatationDetails">Quatation Details</a></li>
								    <li><a data-toggle="tab" href="#SupplierDetails">Supplier Details</a></li>
								  </ul>
							</div><!--end tabs pills-->

							<!--tabs data-->
							<div class="tab-content">
							    <div id="QuatationDetails" class="tab-pane fade in active">
							    	<!--id-date-->
										<div class="id-date">
											<!-- <label class="id">Tender ID:#1225223</label> -->
											<label class="p-date"><i class="far fa-calendar-alt"></i> <span>Publish Date:</span> <?php echo e(date('d-M-y',strtotime($data['quotation']->tendor->created_at))); ?></label>
											<label class="close-date">Close Date: <?php echo e(date('d-M-y',strtotime($data['quotation']->tendor->created_at . ' +' .$data['quotation']->tendor->day . 'days' ))); ?></label>
										</div><!--END id-date-->

									<?php $__currentLoopData = $data['quotation']->quotationProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotationProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							      	<!--product-details-->
									<div class="product-details">
										<div class="single-p-details">
											<div class="table-responsive">
												<table>
													<thead>
														<tr>
															<td>Product Name</td>
															<td>Quantity</td>
															<td>Unit</td>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo e($quotationProduct->product->title); ?></td>
															<td><?php echo e($quotationProduct->product->qty); ?></td>
														    <td><?php echo e($quotationProduct->product->unit); ?></td>
														</tr>
													</tbody>
												</table>
												<div class="discription">
													<p><?php echo e($quotationProduct->product->description); ?></p>
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
													<div class="col-md-12 col-sm-12 col-xs-12">
														<h2>Quotation Details</h2>
													</div>
									
												</div>
											</div>
											<div class="custom-table-height">
												<div class="table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Product Name</th>
																<th>Required Quantity</th>
																<th>Per Unit Price</th>
																<th>Quantity supplier Provide</th>
																<th>Total Price </th>
															</tr>
														</thead>
														<tbody>
															<?php $estimatedTotal = 0 ?>
															<?php $__currentLoopData = $data['quotation']->quotationProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotationProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<!--single table row-->
																<tr>
																	<td><?php echo e($quotationProduct->product->title); ?></td>
																	<td><?php echo e($quotationProduct->product->qty); ?></td>
																	<td><?php echo e($quotationProduct->qty); ?></td>
																	<td><?php echo e(number_format($quotationProduct->price,2)); ?></td>
																	<?php $estimatedTotal += $quotationProduct->price * $quotationProduct->qty ?>
																	<td><?php echo e($quotationProduct->tendor->currency); ?> <?php echo e(number_format($estimatedTotal,2)); ?></td>
																</tr> <!--end-->
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</tbody>

														<tfoot>
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td class="gray-bg">Estimated Total</td>
																<td class="gray-bg"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($estimatedTotal,2)); ?></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<?php $tax = $data['quotation']->tax->tax ?>
																<td>Tax (<?php echo e($data['quotation']->tax->title); ?> <?php echo e($tax); ?> % )</td>
																<td><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($estimatedTotal*($tax/100),2)); ?></td>
															</tr>
															<tr>
																<td colspan="2">
																	<?php if($data['quotation']->status != '2'): ?>
																	<button class="accept" data-url="<?php echo e(route('vendor.quotation.accept',$data['quotation']->id)); ?>">Accept Quotation</button>
																	<button class="reject">Cancel Quotation</button>
																	<?php else: ?>
																	 <p class="text-danger">This quotation is cancelled</p>
																	<?php endif; ?>
																</td>
																<td>Lead Time: <?php echo e($data['quotation']->lead_day); ?> Days</td>
																<td class="gray-bg">Grand  Total</td>
																<td class="gray-bg"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($estimatedTotal + $estimatedTotal*($tax/100),2)); ?> </td>
															</tr>
														</tfoot>
													</table>
												</div>
												<?php if($data['quotation']->status == '2'): ?>
												<div class="table-responsive">
														<table class="table">
												<tr>
													<td>
														<div class="note">
														<span>Cancel Reason*</span>
															<div class="row">
															<div class="col-md-6 col-sm-6 col-xs-12">
															<span>	Cancel By
															<?php if($data['quotation']->cancel_user_id == auth::id()): ?> You <?php else: ?> Seller <?php endif; ?>
															</span>
															</div>
																<div class="col-md-6 col-sm-6 col-xs-12 text-right">
																<span>Date : <?php echo e(date('Y-M-d',strtotime($data['quotation']->cancel_date))); ?></span>
																</div>
															</div>
														   <p><?php echo e($data['quotation']->cancel_reason); ?></p>
														</div>
													</td>
												</tr>
												</table>
												</div>
												<?php endif; ?>
											</div>
										</div>
									</div><!--END Data table-->
							    </div>

							    <div id="SupplierDetails" class="tab-pane fade">
							      	<!--supplier-details-->
									<div class="supplier-profile-details">
										<div class="row">
											<!--supplier profile-->
											<div class="col-md-7 col-sm-7 col-xs-12">
												<div class="profile-details">
													<div class="profile-star clearfix">
														<div class="img">
															<img onerror="profileImgError(this)" src="<?php echo e($data['quotation']->user->profile_image); ?>" class="img-responsive">
														</div>

														<div class="star">
															<h2><img class="betch" onerror="documentImgError(this)" src="<?php echo e(asset('public')); ?>/images/betch.png"><?php if($data['quotation']->user->is_verified == '1'): ?>Verify Supplier <?php else: ?> Not verified supplier <?php endif; ?></h2>

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
															<p class="form-control"><?php echo e($data['quotation']->user->name); ?></p>
														</div>
														<div class="form-group">
															<p class="form-control"><?php echo e($data['quotation']->user->email); ?></p>
														</div>
														<div class="form-group">
															<p class="form-control"><?php echo e($data['quotation']->user->phone); ?></p>
														</div>

														<h2 class="title">Other Details</h2>

														<div class="form-group">
															<p class="form-control"><?php echo e($data['quotation']->user->business_name); ?></p>
														</div>
														<div class="form-group">
															<p class="form-control"><?php echo e($data['quotation']->user->address); ?></p>
														</div>
													</div>

												</div>
											</div><!--END supplier profile-->

											<!--supplier documents-->
											<div class="col-md-5 col-sm-5 col-xs-12">
												<div class="supplier-documents">
													<h2>Business Details & Documents</h2>

													<div class="documents clearfix">
														<?php $__currentLoopData = $data['quotation']->user->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<!--single-document-->
														<div class="single-document">
															<p>Registration No</p>
															<label class="img">
																<img src="<?php echo e($document->document); ?>">
															</label>
														</div><!--end-->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</div>
												</div>
											</div><!--END supplier documents-->
										</div>
									</div><!--END supplier-details-->
							    </div>
							  </div><!--END tabs data-->

						</div><!--END my tenders-->

										  <!-- Modal -->
  <div class="modal fade" id="cancelQuotationModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
         <form action="<?php echo e(route('vendor.quotation.reject',$data['quotation']->id)); ?>" method="post" id="cancelModalForm">
        	<?php echo csrf_field(); ?>
            <?php echo e(method_field('PUT')); ?>

		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Cancel Quotation</h4>
		        </div>
		        <div class="modal-body">
		        	<p>Why are you cancel this quotation?</p>
		          	<div class="form-group">
		          		<textarea class="form-control" placeholder="Please give reason" name="reason" required></textarea>
		          	</div>
		        </div>
		        <div class="modal-footer">
		          <button type="submit" class="btn" style="background: #e45a63;color:#fff">Confirm</button>
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
         </form>
      
    </div>
  </div>
				</div>
				<?php $__env->stopSection(); ?>
				<?php $__env->startPush('js'); ?>
				 <script type="text/javascript">
				 	$('body').on('click','.accept',function(e){
						e.preventDefault();
							var click = $(this);
							var url   = click.attr('data-url');
						 swal({
							  title: "Are you sure?",
							  text: "What to accept this quotation",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							 })
							 .then((willDelete) => {
								if(!willDelete){
									return false;
								}
                             
							$.ajax({
							"headers":{
							'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
							},
							'type':'PUT',
							'url' : url,
							beforeSend: function() {

							},
							'success' : function(response){
							if(response.status == 'success'){
							swal("Success!",response.message, "success");
							  setTimeout(function(e){ window.location.href = "<?php echo e(route('vendor.order.index')); ?>" },1000); 
							}
							if(response.status == 'failed'){
							swal("Failed!",response.message, "error");
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

				 	$('body').on('click','.reject',function(e){
                      $('#cancelQuotationModal').modal('show');
				 	});

				  $('body').on('submit','#cancelModalForm',function(e){
         e.preventDefault();
         var click = $('#cancelQuotationModal');
         let form = $(this);
         let data = form.serialize();
         $.ajax({
          "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          'type':'PUT',
          'url' : form.attr('action'),
          'data' : data,
          beforeSend: function() {
           
          },
          'success' : function(response){
          	click.modal('hide');
        	click.find('textarea').val('');
			click.find('span').hide();
          	if(response.status == 'success'){
 				 swal("Success!",response.message, "success");
 				 setTimeout(function(){ location.reload(); }, 1000);
          	}
          	if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
          	}
        	if(response.status == 'error'){
				$.each(response.errors, function (key, val) {
				click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
				$('.'+key).after('<br><span style="color:red">'+val+'</span>');
				});
        	}
          },
         'error' : function(error){
          console.log(error);
         },
          complete: function() {
               
             },
          });
  	 })

				 </script>
				<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>