<?php $__currentLoopData = auth::user()->notifications->where('is_read','!=','1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 												<li>
 													<?php
 													  $metaData       = unserialize($notification->notification->meta_data);
 													  $redirectUrl    = 'javascript:void(0)';
 													  $notificationId = $notification->notification_id;
 													    if($notification->notification->type == 'tendor')
 													     $redirectUrl = route('supplier.tendor.show',$metaData['tendor_id']);
 													    if($notification->notification->type == 'quotation'){
 													    	if(auth::user()->user_type == '2'){
 													            $redirectUrl = route('vendor.quotation.details',$metaData['quotation_id']);
 													    	}
 													    	if(auth::user()->user_type == '3'){
 													    		$redirectUrl = route('supplier.quotation.show',$metaData['quotation_id']);
 													    	}
 													    }
 													    if($notification->notification->type == 'register'){
                                                             $userType = $metaData['user_type'];
                                                             $userId   = $metaData['user_id'];
                                                             if(auth::user()->user_type == '1'){
                                                             	 if($userType == '2');
                                                                    $redirectUrl = route('admin.vendor.details',$userId);
                                                                 if($userType == '3');
                                                                    $redirectUrl = route('admin.supplier.details',$userId);
                                                                 if($userType == '2')
                                                                 	$redirectUrl = route('admin.supplier.vendor.details',$userId);
                                                             }
                                                             if(auth::user()->user_type == '3' || auth::user()->user_type == '4'){
                                                             	if($userType == '2' || $userType == '4'){
                                                                     $redirectUrl = route('supplier.vendor.show',$userId);
                                                             	}
                                                             }
 													    }
													    if($notification->notification->type == 'request'){
													    	 $userId       = $metaData['user_id'];
													    	 $requestType  = $metaData['type'];
                                                            if($requestType == 'sent_requset'){
                                                            	$redirectUrl = route('vendor.supplier.show',$userId);
                                                            }
                                                           if($requestType == 'accepet_request'){
                                                            	$redirectUrl = route('supplier.my.vendor.details',$userId);
                                                            }
                                                           if($requestType == 'decline_requset'){
                                                           	  $redirectUrl = route('supplier.vendor.show',$userId);
                                                           }
													    }
													    if($notification->notification->type == 'order'){
                                                             $orderId  = $metaData['order_id'];
                                                            if(auth::user()->type == '2')
                                                                 $redirectUrl = route('vendor.order.details',$orderId);
                                                             else
                                                                 $redirectUrl = route('supplier.order.index'.$orderId);
													    }
 													?>
 														<form action="<?php echo e($redirectUrl); ?>" method="get" class="notification-form">
	 														<div class="img-name clearfix">
		 														<div class="img">
		 															<img onerror="profileImgError(this)" src="<?php echo e($notification->notification->sender->profile_image); ?>">
		 														</div>
		 														<div class="txt">
		 															<h2><?php echo e($notification->notification->title); ?></h2>
		 															<span><?php echo e(date('Y-M-d',strtotime($notification->created_at))); ?></span>
		 														</div>
		 													</div>
		 													<p><?php echo e($notification->notification->body); ?></p>
 														</form>
 												</li>
 												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>