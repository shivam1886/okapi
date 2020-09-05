@extends('layouts.loggedInApp')
@section('content')
<div class="main-body">
                    <!-----START searching box--------->
	 				<section class="searching-filter">
						<form method="GET">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="row">
										<div class="col-md-12">
											<div class="input">
												<input type="text" placeholder="Search by business name" name="search" value="{{Request::get('search')}}">
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="filter-btn">
										<a class="button" href="{{route('supplier.quotation.index')}}">Clear</a>
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
										<h2>My Quotation</h2>
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
									<a href="{{route('supplier.quotation.show',$quotation->id)}}">
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
												<div class="submit-mg">
													<p>
														<img src="{{asset('public')}}/images/right1.png">
														Your Quotation is successfully Submit
													</p>
												</div>
												<div class="date-total">
													<label class="close-date">Close Date: {{date('d-m-Y',strtotime($quotation->tendor->created_at . '+'.$quotation->tendor->day.' days'))}}</label>
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