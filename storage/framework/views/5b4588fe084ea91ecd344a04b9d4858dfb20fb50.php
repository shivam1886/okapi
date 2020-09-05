<?php $__env->startSection('content'); ?>
 <div class="main-body">
   <div class="dashboard-data">
   		<div class="row">

           <?php if(auth::user()->user_type == '1'): ?>
               <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('admin.vendors')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Vendors</h2>
                        <h3><?php echo e($data['vendors']); ?></h3>
                     </div>
                  </div>
                  </a>
               </div>

               <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('admin.suppliers')); ?>">
                  <div class="single-data">
                     <div class="img">
                         <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Suppliers</h2>
                        <h3><?php echo e($data['suppliers']); ?></h3>
                     </div>
                  </div>
                 </a>
               </div>

               <div class="col-md-3 col-sm-4 col-xs-12">
                 <a href="<?php echo e(route('admin.vendors')); ?>">
                  <div class="single-data">
                     <div class="img">
                          <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                         <h2>Supplier&Vendors</h2>
                         <h3><?php echo e($data['supplier_vendor']); ?></h3>
                     </div>
                  </div>
               </a>
               </div>
           <?php endif; ?>

           <?php if(auth::user()->user_type == '2' || auth::user()->user_type == '4'): ?>
            
             <!-- Tendor -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('vendor.tendor.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>My Tendors</h2>
                        <h3><?php echo e($data['tendors']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>

            <!-- Quotation -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('vendor.quotation.list')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Quotation</h2>
                        <h3><?php echo e($data['quotations']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>

           <!-- Suppliers -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('vendor.supplier.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Supplier</h2>
                        <h3><?php echo e($data['suppliers']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>

            <!-- Request -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('vendor.request.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Request</h2>
                        <h3><?php echo e($data['requests']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>
             <!-- Order -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('vendor.order.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Order</h2>
                        <h3><?php echo e($data['orders']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>

           <?php endif; ?>

           <?php if(auth::user()->user_type == '3' || auth::user()->user_type == '4'): ?>

             <!-- Tendor -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('supplier.tendor.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Tendors</h2>
                        <h3><?php echo e($data['tendors']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>
            
            <!-- Vendor -->
              <div class="col-md-3 col-sm-4 col-xs-12">
              <a href="<?php echo e(route('supplier.vendor.index')); ?>">
                <div class="single-data">
                  <div class="img">
                  <i class="fa fa-list-alt"></i>
                  </div>
                  <div class="txt">
                    <h2>Vendors</h2>
                    <h3><?php echo e($data['vendors']); ?></h3>
                  </div>
                </div>
              </a>
              </div>
             
             <!-- My vendor -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                 <a href="<?php echo e(route('supplier.my.vendor')); ?>">
                  <div class="single-data">
                     <div class="img">
                          <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                         <h2>My Vendors</h2>
                         <h3><?php echo e($data['my_vendors']); ?></h3>
                     </div>
                  </div>
               </a>
               </div>
               
               <!-- Quotation -->
               <div class="col-md-3 col-sm-4 col-xs-12">
                 <a href="<?php echo e(route('supplier.quotation.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                          <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                         <h2>My Quotation</h2>
                         <h3><?php echo e($data['quotations']); ?></h3>
                     </div>
                  </div>
               </a>
               </div>
                     <!-- Order -->
             <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?php echo e(route('supplier.order.index')); ?>">
                  <div class="single-data">
                     <div class="img">
                        <i class="fa fa-list-alt"></i>
                     </div>
                     <div class="txt">
                        <h2>Order</h2>
                        <h3><?php echo e($data['orders']); ?></h3>
                     </div>
                  </div>
                  </a>
             </div>

           <?php endif; ?>

   		</div>
   </div>
 </div>

 <style type="text/css">
 	.dashboard-data a{
      display: block;
 	}
 	.dashboard-data .single-data{
 		padding: 20px 15px;
 		text-align: center;
	    border-radius: 8px;
	    overflow: hidden;
	    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.13);
	    margin-bottom: 30px;
 	}
 	.dashboard-data .single-data .img{
 		margin: 0 0 20px;
 	}
 	.dashboard-data .single-data .img i{
 		font-size: 40px;
 		color: #e45a63;
 	}
 	.dashboard-data .single-data .txt{
 		
 	}
 	.dashboard-data .single-data .txt h2{
 		margin: 0px 0px 10px;
	    font-size: 18px;
	    font-weight: 600;
	    color: #000;
 	}
 	.dashboard-data .single-data .txt h3{
 		margin: 0;
	    font-size: 20px;
	    font-weight: 600;
	    color: #e45a63;
 	}
 </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.loggedInApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>