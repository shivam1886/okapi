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
											<a href="my_orders.html">My Orders</a>
											<a href="my_orders_details.html"> Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<a href="<?php echo e(route('supplier.order.pdf',$data['order']->id)); ?>" class="download-pdf"><i class="fas fa-download"></i> Download PDF</a>
										<label class="id">Tender ID:#<?php echo e($data['order']->tendor_id); ?></label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tender-details quatation-details my-orders">
					      	<!--product-details-->
							<div class="product-details">
								
								<div class="img-text clearfix">
									<div class="img">
										<img onerror="profileImgError(this)" src="<?php echo e($data['order']->vendor->profile_image); ?>">
									</div>
									<div class="txt">
										<h2><?php echo e($data['order']->vendor->business_name); ?></h2>
										<p><i class="fas fa-map-marker-alt"></i>  <?php echo e($data['order']->vendor->address); ?></p>
									</div>
								</div>	

								<div class="id-date">
									<label class="start-date">Start Date: <?php echo e(date('Y-m-d',strtotime($data['order']->tendor_date))); ?></label>
									<label class="close-date">Closing Date: <?php echo e(date('Y-m-d',strtotime($data['order']->tendor_date . '+ '.$data['order']->close_day.' days'))); ?></label>
								</div>
								<?php $__currentLoopData = $data['order']->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
													<td><?php echo e($item->title); ?></td>
													<td><?php echo e($item->required_qty); ?></td>
													<td><?php echo e($item->unit); ?></td>
												</tr>
											</tbody>
										</table>
										<div class="discription">
											<p><?php echo e($item->description); ?></p>
										</div>
									</div>
								</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div><!--END product-details-->

							<!--Data table-->
							<div class="custom-data-table">
								<div class="data-table">
									<div class="heading-search">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h2>Submit Your Quotation</h2>
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
														<th>Quantity You Provide</th>
														<th>Total Price </th>
													</tr>
												</thead>
												<tbody>
													<?php $estimatedPrice = 0 ?>
													<?php $__currentLoopData = $data['order']->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<!--single table row-->
													<tr>
														<td><?php echo e($item->title); ?></td>
														<td><?php echo e($item->required_qty); ?></td>
														<td><?php echo e($data['order']->currency); ?> <?php echo e($item->price); ?> </td>
														<td><?php echo e($item->supply_qty); ?></td>
														<?php $estimatedPrice += $item->supply_qty*$item->price ?>
														<td><?php echo e($data['order']->currency); ?> <?php echo e(number_format($item->supply_qty*$item->price,2)); ?></td>
													</tr> <!--end-->
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>

												<tfoot>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td class="gray-bg">Estimated Total</td>
														<td class="gray-bg"><?php echo e($data['order']->currency); ?> <?php echo e(number_format($estimatedPrice,2)); ?></td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td><?php echo e($data['order']->tax_title); ?> <?php echo e($data['order']->tax); ?> % </td>
														<td><?php echo e($data['order']->currency); ?> <?php echo e(number_format($estimatedPrice*($data['order']->tax/100),2)); ?></td>
													</tr>
													<tr>
														<td colspan="2">
															<div class="order-status status-btn">
																<div class="choose-tax">
																	<span>Order Status</span>
																	<select data-url="<?php echo e(route('supplier.change.order',$data['order']->id)); ?>" class="custome-order-status" <?php if($data['order']->status == '4'): ?> disabled <?php endif; ?>>
																		<option <?php if($data['order']->status == '0'): ?> selected <?php endif; ?> value="0">Pending</option>
																		<option <?php if($data['order']->status == '1'): ?> selected <?php endif; ?> value="1">Processing</option>
																		<option <?php if($data['order']->status == '2'): ?> selected <?php endif; ?> value="2">Dispatch</option>
																		<option <?php if($data['order']->status == '3'): ?> selected <?php endif; ?> value="3">Delivered</option>
																		<?php if($data['order']->status=='4'): ?>
																		<option <?php if($data['order']->status == '4'): ?> selected <?php endif; ?> value="4">Cancel</option>
																		<?php endif; ?>
																		<?php if($data['order']->status=='3' || $data['order']->status=='5'): ?>
																		<option <?php if($data['order']->status == '5'): ?> selected <?php endif; ?> value="4">Received</option>
																		<?php endif; ?>
																	</select>
																</div>
																<?php if($data['order']->status != '3' && $data['order']->status != '4' && $data['order']->status != '5'): ?>
																<button class="cancel-order save" style="background: #e45a63" data-url="<?php echo e(route('vendor.cancel.order',$data['order']->id)); ?>">Cancel</button>
																<?php endif; ?>
															</div>
														</td>
														<td></td>
														<td class="gray-bg">Grand  Total</td>
					<td class="gray-bg"><?php echo e($data['order']->currency); ?> <?php echo e(number_format($estimatedPrice + ($estimatedPrice*($data['order']->tax/100)),2)); ?></td>
													</tr>
												</tfoot>
											</table>
										</div>
                                        
                                          <?php if($data['order']->status == '4'): ?>
												<div class="note">
												<span>Cancel Reason*</span>
												<div class="row">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<span>	
											             <?php if($data['order']->cancel_user_id == auth::id()): ?>
											               Cancel By You
											             <?php else: ?>
											              Cancel By Vendor
											              <?php endif; ?>
											             </span>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12 text-right">
														<span>Date : <?php echo e(date('d-M-Y',strtotime($data['order']->cancel_date))); ?></span>
													</div>
												</div>
												<p><?php echo e($data['order']->cancel_reason); ?></p>
											</div>
										  <?php endif; ?>

								
									</div>
								</div>
							</div><!--END Data table-->

						</div><!--END my tenders-->

					</div>

  <!-- Modal -->
  <div class="modal fade" id="cancelOrderModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
         <form action="<?php echo e(route('supplier.cancel.order',$data['order']->id)); ?>" method="post" id="cancelOrderForm">
        	<?php echo csrf_field(); ?>
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Cancel Order</h4>
		        </div>
		        <div class="modal-body">
		        	<p>Why are you cancel this order?</p>
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


<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
 <script type="text/javascript">
  	 
  	 $('body').on('click','.cancel-order',function(e){
         $('#cancelOrderModal').modal('show');
  	 });

  	 $('body').on('submit','#cancelOrderForm',function(e){
         e.preventDefault();
         var click = $('#cancelOrderModal');
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
          	console.log(response);
          	return false;
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

  	   $('body').on('change','.custome-order-status',function(e){
  	  	    e.preventDefault();
  	  	     swal({
		  title: "Are you sure?",
		  text: "Change the order status",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		 })
		 .then((willDelete) => {
			if(!willDelete){
				return false;
			}
	        var click = $(this);
	        var url   = $(this).attr('data-url');
            let data  = {status:$(this).val()};
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'PUT',
				'url' : url,
				'data' : data,
			beforeSend: function() {

			},
			'success' : function(response){
				console.log(response);
				if(response.status == 'success'){
   			      swal("Success!",response.message, "success");
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

 </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>