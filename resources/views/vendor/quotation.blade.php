@extends('layouts.loggedInApp')
@section('content')
<div class="main-body">

				<!-----START searching box--------->
					<section class="searching-filter">
						<form method="GET">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="input">
										<input type="text" placeholder="Search by business name" name="search" value="{{Request::get('search')}}">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
							    	<div class="filter-btn">
										 <select name="status">
										 	<option value="">-- All --</option>
										 	<option @if(Request::get('status') == '0') selected @endif value="0">Pending</option>
										 	<option @if(Request::get('status') == '2') selected @endif value="2">Cancel</option>
										 </select>

										 <a class="button" href="{{route('vendor.quotation.list')}}">Clear</a>
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
										<h2>Supplier Quotation</h2>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tenders">
							<div class="row">
								@foreach($data['quotations'] as $key => $quotation)
								<!--single-tender-->
								<div class="col-md-6 col-sm-6 col-xs-12">
									<a href="{{route('vendor.quotation.details',$quotation->id)}}">
										<div class="single-tender">
											<div class="heading">
												<h2>{{$quotation->tendor->user->business_name}}</h2>
												<p class="address"><i class="fas fa-map-marker-alt"></i> &nbsp; {{$quotation->tendor->user->address}}</p>
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
								                           @foreach($quotation->tendor->products  as $product)
																<tr>
																	<td>{{$product->title}}</td>
																	<td>{{$product->qty}} {{$product->unit}}</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
												<div class="date-total">
													<label class="close-date">Submitted Date: {{date('Y-M-d',strtotime($quotation->created_at))}}</label>
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