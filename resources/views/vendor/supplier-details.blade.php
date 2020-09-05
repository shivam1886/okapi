@extends('layouts.loggedInApp')
@section('content')
	<div class="main-body">
					<div class="inner-body">
						<!--header-->
						<div class="header">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="title">
										<!-- <h2>My Tenders</h2> -->
										<p class="navigation">
											<a href="{{route('vendor.supplier.index')}}">Supplier List</a>
											<a href="javascript:void(0)">Supplier Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Supplier ID:#{{$user->supplier_id}}</label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--supplier-details-->
						<div class="supplier-profile-details">
							<div class="row">
								<!--supplier profile-->
								<div class="col-md-7 col-sm-7 col-xs-12">
									<div class="profile-details">
										<div class="profile-star clearfix">
											<div class="img">
												<img onerror="profileImgError(this)" src="{{$user->profile_image}}" class="img-responsive">
											</div>

											<div class="star">
												<h2><img class="betch" src="{{asset('public')}}/images/betch.png">@if($user->is_verified == '1')  Verify supplier @else Unverified suppliser @endif</h2>

												<div class="star-rating">
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
													<label>
														<input type="checkbox" checked name="">
														<span><i class="fas fa-star"></i></span>
													</label>
												</div>
											</div>
										</div>

										<div class="input-details">
											<div class="form-group">
												<p class="form-control">{{$user->name}}</p>
											</div>
											<div class="form-group">
												<p class="form-control">{{$user->email}}</p>
											</div>
											<div class="form-group">
												<p class="form-control">{{$user->phone}}</p>
											</div>

											<h2 class="title">Other Details</h2>

											<div class="form-group">
												<p class="form-control">{{$user->business_name}}</p>
											</div>
											<div class="form-group">
												<p class="form-control">{{$user->address}}</p>
											</div>
										</div>

									</div>
								</div><!--END supplier profile-->

								<!--supplier documents-->
								<div class="col-md-5 col-sm-5 col-xs-12">
									<div class="supplier-documents">
										<h2>Business Details & Documents</h2>

										<div class="documents clearfix">
											@if($user->documents)
												   @foreach($user->documents as $key => $document)
													<!--single-document-->
													<div class="single-document">
														<p>Registration No</p>
														<label class="img">
															<img src="{{$document->document}}">
														</label>
													</div><!--end-->
												@endforeach
											@endif
										</div>
									</div>
								</div><!--END supplier documents-->
							</div>
						</div><!--END supplier-details-->

					</div>	
				</div>
@endsection
