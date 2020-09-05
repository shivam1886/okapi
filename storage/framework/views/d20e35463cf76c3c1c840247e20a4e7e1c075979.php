<?php $__env->startSection('content'); ?>
		<div class="main-body">
                <form action="<?php echo e(route('vendor.tendor.store')); ?>" method="post" id="tendor-add-form">
                    <?php echo csrf_field(); ?>
					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
											<a href="<?php echo e(route('vendor.tendor.index')); ?>">Tenders</a>
											<a href="javascript:void(0)">add Tenders</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="btns">
										<button class="add-tender submit-form">Add Tenders</button>
									</div>
								</div>
							</div>
						</div><!--END header-->
							<!--my tenders-->
							<div class="add-tenders">
								<h2 class="title">Add Tenders</h2>
								<div class="choose-currency">
									<h4 class="sub-title">choose currency</h4>
									<select name="currency" class="form-control1">
										<?php $__currentLoopData = auth::user()->currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <?php if($key == 0): ?>
                                              <option value="">-- Select Currency --</option>
                                           <?php endif; ?>
                                           <option value="<?php echo e($currency->title); ?>"><?php echo e($currency->title); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								<div class="product-list">
								</div>
								<div class="add-product-btn">
									<button class="add-product"><i class="fas fa-plus"></i> Add More Product</button>
								</div>
								<!--tender close-->
								<div class="tender-close-in">
									<h4 class="sub-title">Tender Close in</h4>
									<div class="clearfix">
										<div class="day">
											<span>Day</span>
											<input type="number" class="form-control1" placeholder="00" name="day" required>
										</div>
										<button class="select-suppliers" data-toggle="modal" data-target="#SelectSupplier">Select Supplier </button>
									</div>
								</div><!--end-->
							</div><!--END my tenders-->
						<!-- Modal -->
						<div class="modal fade SelectSupplier-modal" id="SelectSupplier" role="dialog">
						<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Select Supplier</h4>
						</div>
						<div class="modal-body">
						<div class="custom-data-table">
						<div class="data-table">
						<div class="heading-search">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<h2>
										<label class="item-checkbox">
											<input type="checkbox" class="selectall">
											<span></span>
										</label>
										Select All
									</h2>
								</div>
							</div>
						</div>
						<div class="custom-table-height">
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th></th>
											<th>Suplier Name</th>
											<th>Verify Suplier</th>
											<th>Phone Number </th>
											<th>Address</th>
										</tr>
									</thead>
									<tbody class="all-checkboxes">
										<?php $__currentLoopData = $data['suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<!--single table row-->
										<tr>
											<td>
												<label class="item-checkbox">
													<input type="checkbox" name="suppliers[]" value="<?php echo e($supplier->supplier_id); ?>">
													<span></span>
												</label>
											</td>
											<td><?php echo e($supplier->user->name); ?></td>
											<td> <img class="betch" src="<?php echo e(asset('public')); ?>/images/betch.png"> <span class="verify"><?php echo e($supplier->user->is_verified == '1' ? 'Verify Supplier' : 'Unverified Supplier'); ?></span> </td>
											<td><?php echo e($supplier->user->phone); ?></td>
											<td><?php echo e($supplier->user->address); ?></td>
										</tr> <!--end-->
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
					</div>
				</form>
		</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
 <script type="text/javascript">

 	var product = function(){

		html =  '<div class="single-entry">';
			html += '<div class="form-group">';
				html += '<h4 class="sub-title">Prodct Title</h4>';
				html += '<input type="text" class="form-control2" placeholder="Prodct Title" name="title[]" required>';
				html += '</div>';
				html += '<div class="form-group">';
				html += '<h4 class="sub-title">Qty.</h4>';
				html += '<input type="number" class="form-control3" placeholder="00" name="qty[]" required>';
				html += '</div>';
				html += '<h4 class="sub-title">Unit</h4>';
				html += '<input type="text" class="form-control3" placeholder="" name="unit[]" required>';
				html += '</div>';
				html += '<div class="form-group">';
				html += '<h4 class="sub-title">Description</h4>';
				html += '<textarea rows="4" class="form-control4" placeholder="Write here..." name="description[]" required></textarea>';
				html += '</div>';
			    html += '<button class="delete-btn"> <i class="fas fa-trash-alt"></i> Remove</button>';
		        html += '</div>';
		        return html;
 	}

 	 $('.select-suppliers').on('click',function(e){
         e.preventDefault();
 	 });

     $(function(){
     	$('.product-list').html(product());
     })

 	$('body').on('click','.add-product',function(e){
  		  $('.product-list').append(product());
 	});

    $('body').on('click','.delete-btn',function(e){
 		 e.preventDefault();
 		 child = $('.product-list').children().length;
 		 if(child > 1)
 		     $(this).parents('.single-entry').remove();
 	     else
             swal('Minimum one product is required');
 	});

 	$('body').on('submit','#tendor-add-form',function(e){
 		  e.preventDefault();
          var click = $(this);
       	  let form = $(this);
          let data = form.serialize();
         $.ajax({
          "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          'type':'POST',
          'url' : form.attr('action'),
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

	$('.selectall').click(function() {
		if ($(this).is(':checked')) {
		   $('input[type="checkbox"]').attr('checked', true);
		} else {
		   $('input[type="checkbox"]').attr('checked', false);
		}
	});

 </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>