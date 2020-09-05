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
												<input type="text" placeholder="Search by product name" name="search" value="<?php echo e(Request::get('search')); ?>">
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="filter-btn">
										<a class="button" href="<?php echo e(route('supplier.product.index')); ?>">Clear</a>
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
										<h2>Product & Catalogue</h2>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="btns">
										<button class="add-tender" id="add-product"><i class="fas fa-plus"></i> Add Product</button>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--product-catalogue-->
						<div class="product-catalogue">
							<div class="row">
								<?php $__currentLoopData = $data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<!--single-->
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="single-pc" data-id="<?php echo e($product->id); ?>">
									<h2><?php echo e($product->title); ?></h2>
										<div class="price">
										   <p>Price: <span><?php echo e($product->currency); ?> <?php echo e($product->price); ?></span></p>
										</div>
									</div>
								</div><!--END-->
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div><!--END my tenders-->
					</div>

					  					  <!-- Modal -->
					  <div class="modal fade add-product-modal" id="addProductModal" role="dialog">
					    <div class="modal-dialog modal-md">
					      <!-- Modal content-->
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Add Product</h4>
					        </div>
					        <div class="modal-body">
					          <form action="<?php echo e(route('supplier.product.store')); ?>" method="post" id="addProductForm">
					          	<?php echo csrf_field(); ?>
					          <div class="add-product">
					          	<div class="form-group">
					          		<input type="text" class="form-control" placeholder="Product Title" name="title">
					          	</div>
					          	<div class="form-group">
					          		<textarea rows="4" class="form-control" placeholder="Prouct Description" name="description"></textarea>
					          	</div>

					          	<div class="price">
									<select name="currency" required>
										<?php $__currentLoopData = auth::user()->currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										    <?php if($key == '0'): ?>
										     <option value="">--Currency--</option>
										    <?php endif; ?>
											<option value="<?php echo e($currency->title); ?>"><?php echo e($currency->title); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<input type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" placeholder="Price" value="" name="price">
								</div>
								<button type="submit">  Add</button>
					          </div>
					          </form>
					        </div>
					      </div>
					    </div>
					  </div><!--END-->

					  					  <!-- Modal -->
					  <div class="modal fade add-product-modal" id="editProductModal" role="dialog">
					    <div class="modal-dialog modal-md">
					      <!-- Modal content-->
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Update Product</h4>
					        </div>
					        <div class="modal-body">
					          <form action="<?php echo e(route('supplier.product.update')); ?>" method="post" id="updateProductForm">
					          	<?php echo csrf_field(); ?>
					          	<?php echo e(method_field('PUT')); ?>

					          	<input type="hidden" name="id" value="">
					          <div class="add-product">
					          	<div class="form-group">
					          		<input type="text" class="form-control" placeholder="Product Title" name="title">
					          	</div>
					          	<div class="form-group">
					          		<textarea rows="4" class="form-control" placeholder="Prouct Description" name="description"></textarea>
					          	</div>

					          	<div class="price">
                                    <select oninvalid="this.setCustomValidity('Please select currency')" name="currency" required>
										<?php $__currentLoopData = auth::user()->currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										    <?php if($key == '0'): ?>
										     <option value="">--Currency--</option>
										    <?php endif; ?>
											<option value="<?php echo e($currency->title); ?>"><?php echo e($currency->title); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<input type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" placeholder="Price" value="" name="price">
								</div>
					            <button class="delete-btn" data-url="" style="background:#e45a63"> Delete</button>
								<button> Update</button>
					          </div>
					          </form>
					        </div>
					      </div>
					    </div>
					  </div><!--END-->

				</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
 <script type="text/javascript">
 	  	  // Get Documents
  	    var getProducts = function(){
					$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "<?php echo e(route('supplier.product.index')); ?>",
					beforeSend: function() {

					},
					'success' : function(response){
              	        $('.product-catalogue .row').html(response);
					},
  					'error' : function(error){
					},
					complete: function() {
					},
					});
  	    }
  	     $('body').on('click','#add-product',function(e){
				$('#addProductForm input').val('');
				$('#addProductForm textarea').val('');
  	    	    $('#addProductModal').modal('show');
  	     });

  	    $('body').on('click','.single-pc',function(e){
  	    	    var id    = $(this).attr('data-id');
  	    	    var data  = {id : id};
  	    	    var modal = $('#editProductModal'); 
  	    	$.ajax(
					{
						"headers":{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
						'type':'get',
						'url' : "<?php echo e(route('supplier.product.edit')); ?>",
						'data' : data,
					beforeSend: function() {

					},
					'success' : function(response){
                       if(response.status){
							 modal.find('input[name="id"]').val(response.data.id);
		 					 modal.find('input[name="title"]').val(response.data.title);
							 modal.find('textarea[name="description"]').val(response.data.description);
						     modal.find('input[name="price"]').val(response.data.price);
						     modal.find('select[name="currency"]').val(response.data.currency);
						     modal.find('.delete-btn').attr('data-url',response.data.url);
	    	    	         modal.modal('show');
                       }else{
                          swal('Something went wrong please try later');
                       }
					},
  					'error' : function(error){
					},
					complete: function() {
					},
					});
  	    });

  	    $('body').on('submit','#addProductForm',function(e){
  	    	e.preventDefault();
	        var click = $(this);
			let form  = $(this);
            let data  = form.serialize();
            var modal = $('#addProductModal');

			$.ajax({
 				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'post',
				'url' : form.attr('action'),
				'data' : data,
			beforeSend: function() {

			},
			'success' : function(response){
 				click.find('span').hide();
				if(response.status == 'success'){
                  getProducts();
                  modal.modal('hide');
   			      swal("Success!",response.message, "success");
				}
				if(response.status == 'failed'){
                  modal.modal('hide');
				  swal("Failed!",response.message, "error");
				}
				if(response.status == 'error'){
					 $.each(response.errors, function (key, val) {
					 click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
					 });
				}
			},
			'error' : function(error){
				console.log(error);
			},
			complete: function() {

			},
			});
  	    });

  	    $('body').on('submit','#updateProductForm',function(e){
  	    	e.preventDefault();
	        var click = $(this);
			let form  = $(this);
            let data  = form.serialize();
            var modal = $('#editProductModal'); 
			$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
				'type':'post',
				'url' : form.attr('action'),
				'data' : data,
			beforeSend: function() {

			},
			'success' : function(response){
 				click.find('span').hide();
				if(response.status == 'success'){
                  getProducts();
                  modal.modal('hide');
   			      swal("Success!",response.message, "success");
				}
				if(response.status == 'failed'){
                  modal.modal('hide');
				  swal("Failed!",response.message, "error");
				}
				if(response.status == 'error'){
					 $.each(response.errors, function (key, val) {
					 click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
					 });
				}
			},
			'error' : function(error){
				console.log(error);
			},
			complete: function() {

			},
			});
  	    });

  	    $('body').on('click','.delete-btn',function(e){
  	    	e.preventDefault();
        	 swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this department file!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		 })
		 .then((willDelete) => {
			if(!willDelete){
				return false;
			}
          var url = $(this).attr('data-url');
				$.ajax({
					"headers":{
					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
				},
					'type':'DELETE',
					'url' : url,
				beforeSend: function() {
				},
				'success' : function(response){
					if(response.status == 'success'){
					    getProducts();
						swal("Success!",response.message, "success");
						$('#editProductModal').modal('hide');
					}
					if(response.status == 'failed'){
						swal("Failed!",response.message, "error");
					}
				},
				'error' : function(error){
				},
				complete: function() {
				},
				});
		 });
  	    });
 </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>