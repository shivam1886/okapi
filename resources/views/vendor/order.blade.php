@extends('layouts.loggedInApp')
@section('content')
<div class="main-body">

		 <!-----START searching box--------->
					<section class="searching-filter">
						<form method="GET">
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-md-4">
											<div class="input">
												<input type="text" placeholder="Search by business name" name="search" value="{{Request::get('search')}}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
												<input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Day" name="day" value="{{Request::get('day')}}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
											     <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Month" name="month" value="{{Request::get('month')}}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input">
											     <input type="year" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Year" name="year" value="{{Request::get('year')}}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="filter-btn">
                                               <select name="status">
                                               	 <option value="">--All-</option>
                                               	 <option @if(Request::get('status') == '1') selected @endif value="1">Processing</option>
                                               	 <option @if(Request::get('status') == '2') selected @endif value="2">Dispatch</option>
                                               	 <option @if(Request::get('status') == '3') selected @endif value="3">Delivered</option>
                                               	 <option @if(Request::get('status') == '4') selected @endif value="4">Cancel</option>
                                               </select>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3 col-xs-3">
									<div class="filter-btn">
										<a class="button" href="{{route('vendor.order.index')}}">Clear</a>
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
																	<td>{{$item->required_qty}}</td>
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