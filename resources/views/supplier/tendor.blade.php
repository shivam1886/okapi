@extends('layouts.loggedInApp')
@section('content')
<div class="main-body">
					<div class="header-banner" style="background-image: url('{{asset('public')}}/images/banner.jpg');">
						<div class="txt-wrapper">
							<div class="txt">
								<h2>Publishing and graphic design, Lorem ipsum is a placeholder text commonly used to </h2>
								<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a </p>
							</div>
						</div>
					</div>

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
										<a class="button" href="{{route('supplier.tendor.index')}}">Clear</a>
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
										<h2>Explore Tenders</h2>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
							{{-- 		<div class="btns">
										<select>
											<option disabled selected>Short By</option>
											<option>All Tenders</option>
										</select>
									</div> --}}
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tenders">
							<div class="row">
								@foreach($data['tendors'] as $tendor)
									<!--single-tender-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<a href="{{route('supplier.tendor.show',$tendor->id)}}">
											<div class="single-tender">
												<div class="heading">
													<h2>{{$tendor->user->business_name}}</h2>
													<p class="address"><i class="fas fa-map-marker-alt"></i> &nbsp; {{$tendor->user->address}}</p>
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
																@if($tendor)
																	@forelse($tendor->products as $product)
																	<tr>
																		<td>{{$product->title}}</td>
																		<td>{{$product->qty}} {{$product->unit}}</td>
																	</tr>
																@empty
																@endforelse
																</tbody>
															</table>
														@endif
													</div>
													<div class="date-total">
														<label class="close-date">Close Date: {{date('d-m-Y',strtotime($tendor->created_at . '+'.$tendor->day.' days'))}}</label>
													</div>
												</div>

												<span class="arrow"><i class="fas fa-arrow-right"></i></span>
											</div>
										</a>
									</div><!--END single-tender-->
								@endforeach
							</div>
						</div><!--END my tenders-->

					</div>	
				</div>
@endsection