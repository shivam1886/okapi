<!DOCTYPE html>
<html>
<head>
	<title>My Order</title>
</head>
<body>
	<div style="padding: 30px; margin: 0 auto; width: 1000px; border: 1px solid #ababab;">
		<table cellspacing="0" cellpadding="0" border="0" align="center" style="width: 100%; font-family: 'Poppins', sans-serif; line-height: 1.4">
			<tbody>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" border="0"  style="width: 100%;">
							<tbody>
								<tr>
									<td>
										<h2 style="margin: 0;">{{$data['order']->supplier->business_name}}</h2>
										<p style="margin: 0;">{{$data['order']->supplier->address}}</p>
										<div style=" height: 10px; padding-bottom: 10px; border-bottom: 1px solid #ababab;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div style="height: 20px;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<p style="background: #e6fcee; color: #03c84d; padding: 8px 12px; border-radius: 4px; margin: 0 5px; display: inline-block;">Start Date: {{date('Y-M-d',strtotime($data['order']->tendor_date))}}</p>
										<p style="background: #f7e9ea; color: #e45a63; padding: 8px 12px; border-radius: 4px; margin: 0 5px; display: inline-block;">Closing Date: {{date('Y-M-d',strtotime($data['order']->tendor_date .'+'. $data['order']->close_day  .' days'))}}</p>
										<div style="padding-bottom: 10px; border-bottom: 1px solid #ababab;"></div>
									</td>
								</tr>
								@foreach($data['order']->items as $item)
								 <tr>
									<td>
										<table cellspacing="0" cellpadding="0" border="0"  style="width: 100%;">
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
													<td style="color: #000; padding: 10px 0 5px; font-size: 15px; font-weight: 600;">{{$item->title}}</td>
													<td style="color: #000; padding: 10px 0 5px; font-size: 15px; font-weight: 600;">{{$item->required_qty}}</td>
													<td style="color: #000; padding: 10px 0 5px; font-size: 15px; font-weight: 600;">{{$item->unit}}</td>
													<td></td>
												</tr>
												<tr>
													<td colspan="2">
														<p style="margin: 0; font-size: 14px; color: #000;">{{$item->description}}</p>
													</td>
												</tr><!--END Single-->
											</tbody>
										</table>
									</td>
								</tr>
								@endforeach
								<tr>
									<td>
										<div style="height: 20px;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div style="padding: 80px 0; border-bottom: 1px solid #ababab;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div style="height: 20px;"></div>
									</td>
								</tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0" border="0"  style="width: 100%;">
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
													@php $estimatedPrice = 0 @endphp
													@foreach($data['order']->items as $item)
													<tr>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$item->title}}</td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$item->required_qty}}</td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$data['order']->currency}} {{$item->price}} </td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$item->supply_qty}}</td>
														@php $estimatedPrice += $item->supply_qty*$item->price @endphp
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$data['order']->currency}} {{number_format($item->supply_qty*$item->price,2)}}</td>
													</tr> <!--end-->
													@endforeach
												</tbody>

												<tfoot>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;">Estimated Total</td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;">{{$data['order']->currency}} {{number_format($estimatedPrice,2)}}</td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$data['order']->tax_title}} {{$data['order']->tax}} % </td>
														<td style="color: #000; padding: 5px 0; font-size: 15px; font-weight: 600;">{{$data['order']->currency}} {{number_format($estimatedPrice*($data['order']->tax/100),2)}}</td>
													</tr>
													<tr>
														<td colspan="2">
															<span style="display: block; font-size: 15px; margin: 0 0 5px; font-weight: 500; color: #848484;">Order Status</span>
															<select style="width: 120px; padding: 0 5px; font-size: 14px; border-radius: 6px; border: 1px solid #000; height: 35px;">
														             	<option @if($data['order']->status == '0') selected @endif value="">Pending</option>
																		<option @if($data['order']->status == '1') selected @endif value="1">Processing</option>
																		<option @if($data['order']->status == '2') selected @endif value="2">Dispatch</option>
																		<option @if($data['order']->status == '3') selected @endif value="3">Delivered</option>
																		<option @if($data['order']->status == '4') selected @endif value="4">Cancel</option>
															</select>
														</td>
														<td></td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;">Grand  Total</td>
														<td style="color: #000; padding: 10px 10px; font-size: 15px; font-weight: 600; background: #eaeaea;">{{$data['order']->currency}} {{number_format($estimatedPrice + $estimatedPrice*($data['order']->tax/100),2)}}</td>
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