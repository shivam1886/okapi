<!DOCTYPE html>
<html>
<head>
	<title>My Order</title>
</head>
<body>
	<div style="padding: 30px; margin: 0 auto; width: 1000px; bquotation: 1px solid #ababab;">
		<table cellspacing="0" cellpadding="0" bquotation="0" align="center" style="width: 100%; font-family: 'Poppins', sans-serif; line-height: 1.4">
			<tbody>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" bquotation="0"  style="width: 100%;">
							<tbody>
								<tr>
									<td>
										<h2 style="margin: 0;"><?php echo e($data['quotation']->user->business_name); ?></h2>
										<p style="margin: 0;"><?php echo e($data['quotation']->user->address); ?></p>
										<div style=" height: 10px; padding-bottom: 10px; bquotation-bottom: 1px solid #ababab;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div style="height: 20px;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<p style="background: #e6fcee; color: #03c84d; padding: 8px 12px; bquotation-radius: 4px; margin: 0 5px; display: inline-block;">Start Date: <?php echo e(date('Y-M-d',strtotime($data['quotation']->tendor->created_at))); ?></p>
										<p style="background: #f7e9ea; color: #e45a63; padding: 8px 12px; bquotation-radius: 4px; margin: 0 5px; display: inline-block;">Closing Date: <?php echo e(date('Y-M-d',strtotime($data['quotation']->tendor->created_at .'+'. $data['quotation']->tendor->close_day  .' days'))); ?></p>
										<div style="padding-bottom: 10px; bquotation-bottom: 1px solid #ababab;"></div>
									</td>
								</tr>
								<?php $__currentLoopData = $data['quotation']->tendor->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								 <tr>
									<td>
										<table cellspacing="0" cellpadding="0" bquotation="0"  style="width: 100%;">
											<thead>
												<tr>
													<td style="color: #848484; padding-bottom: 5px; font-size: 15px; font-weight: 500;">Product Name</td>
													<td style="color: #848484; padding-bottom: 5px; font-size: 15px; font-weight: 500;">Quantity</td>
													<td style="color: #848484; padding-bottom: 5px; font-size: 15px; font-weight: 500;">Unit</td>
													<td></td>
												</tr>
											</thead>
											<tbody>
												<!--START Single-->
												<tr>
													<td style="color: #000; padding: 10px 0 5px; font-size: 15px; font-weight: 600;"><?php echo e($product->title); ?></td>
													<td style="color: #000; padding: 10px 0 5px; font-size: 15px; font-weight: 600;"><?php echo e($product->qty); ?></td>
													<td style="color: #000; padding: 10px 0 5px; font-size: 15px; font-weight: 600;"><?php echo e($product->unit); ?></td>
													<td></td>
												</tr>
												<tr>
													<td colspan="2">
														<p style="margin: 0; font-size: 14px; color: #000;"><?php echo e($product->description); ?></p>
													</td>
												</tr><!--END Single-->
											</tbody>
										</table>
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td>
										<div style="height: 20px;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div style="padding: 80px 0; bquotation-bottom: 1px solid #ababab;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div style="height: 20px;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0" bquotation="0"  style="width: 100%;">
												<thead>
													<tr>
														<td style="color: #848484; padding-bottom: 10px; font-size: 15px; font-weight: 500;">Product Name</td>
														<td style="color: #848484; padding-bottom: 10px; font-size: 15px; font-weight: 500;">Required Quantity</td>
														<td style="color: #848484; padding-bottom: 10px; font-size: 15px; font-weight: 500;">Per Unit Price</td>
														<td style="color: #848484; padding-bottom: 10px; font-size: 15px; font-weight: 500;">Quantity You Provide</td>
														<td style="color: #848484; padding-bottom: 10px; font-size: 15px; font-weight: 500;">Total Price </td>
													</tr>
												</thead>
												<tbody>
													<?php $estimatedPrice = 0 ?>
													<?php $__currentLoopData = $data['quotation']->quotationProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<tr>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($product->product->title); ?></td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($product->product->qty); ?></td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e($product->price); ?> </td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($product->qty); ?></td>
														<?php $estimatedPrice += $product->qty*$product->price ?>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($product->qty*$product->price,2)); ?></td>
													</tr> <!--end-->
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>

												<tfoot>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;">Estimated Total</td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($estimatedPrice,2)); ?></td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($data['quotation']->tax->tax_title); ?> <?php echo e($data['quotation']->tax->tax); ?> % </td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($estimatedPrice*($data['quotation']->tax->tax/100),2)); ?></td>
													</tr>
													<tr>
														<td colspan="2">
															<span style="display: block; font-size: 15px; margin: 0 0 5px; font-weight: 500; color: #848484;">Quotation Status</span>
															<select style="width: 120px; padding: 0 5px; font-size: 14px; bquotation-radius: 6px; bquotation: 1px solid #000; height: 35px;">
														             	<option <?php if($data['quotation']->status == '0'): ?> selected <?php endif; ?> value="0">Pending</option>
																		<option <?php if($data['quotation']->status == '1'): ?> selected <?php endif; ?> value="1">Processing</option>
																		<option <?php if($data['quotation']->status == '2'): ?> selected <?php endif; ?> value="2">Dispatch</option>
																		<option <?php if($data['quotation']->status == '3'): ?> selected <?php endif; ?> value="3">Delivered</option>
																		<option <?php if($data['quotation']->status == '4'): ?> selected <?php endif; ?> value="4">Cancel</option>
															</select>
														</td>
														<td></td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;">Grand  Total</td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;"><?php echo e($data['quotation']->tendor->currency); ?> <?php echo e(number_format($estimatedPrice + $estimatedPrice*($data['quotation']->tax->tax/100),2)); ?></td>
													</tr>
												</tfoot>
											</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>