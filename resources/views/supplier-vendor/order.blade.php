@extends('layouts.loggedInApp')
@section('content')
<div class="main-body">

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
								@foreach($data['orders'] as $key => $order)
									<!--single-tender-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<a href="{{route('vendor.order.show',$order->id)}}">
											<div class="single-tender">
											<div class="heading">
												<p><i class="far fa-calendar-alt"></i> <span>Order Date</span>{{date('d-M-Y',strtotime($order->created_at))}}</p>
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
															@foreach($order->items as $item)
																<tr>
																	<td>{{$item->title}}</td>
																	<td>{{$item->supply_qty}}</td>
																</tr>
															@endforeach
														</tbody>
														<tfoot>
															<tr>
																<td>
																	Status:
																	@if($order->status == '1')
																	   <span class="recived" style="color:orange">Processing</span>
																	@elseif($order->status == '2')
																	    <span class="recived">Dispatch</span>
																	@elseif($order->status == '3')
																	    <span class="recived" style="color:green">Delivered</span>
																	@elseif($order->status == '4')
    																	<span class="recived" style="color:red">Cancelled</span>
    																@else
    																    <span class="recived">Pending</span>
																	@endif
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
								@endforeach
							</div>
						</div><!--END my tenders-->

					</div>	
				</div>
@endsection