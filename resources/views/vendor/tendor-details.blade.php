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
										<p class="navigation"><a href="{{route('vendor.tendor.index')}}">My Tenders</a><a href="javascript:void(0)">Tendor Details</a></p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="btns">
										<a  href="{{route('vendor.tendor.edit',$data['tendor']->id)}}" class="edit-tender">Edit Tenders</a>
									    <button class="delete-tender">Delete Tenders</button>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tender-details">
							<!--id-date-->
							<div class="id-date">
								<label class="id">Tender ID:#{{$data['tendor']->id}}</label>
								<label class="p-date"><i class="far fa-calendar-alt"></i> <span>Publish Date:</span>{{date('d-m-Y',strtotime($data['tendor']->created_at))}}</label>
								<label class="close-date">Close Date: {{date('d-m-Y',strtotime($data['tendor']->created_at . '+' .$data['tendor']->day. 'days'))}}</label>
							</div><!--END id-date-->

												@foreach($data['tendor']->products as $product)
	                        <!--product-details-->
							<div class="product-details">
								<div class="single-p-details">
									<div class="table-responsive">
										<table>
											<thead>
												<tr>
													<td>Product Name</td>
													<td>Product Qty</td>
													<td>Unit</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{$product->title}}</td>
													<td>{{$product->qty}}</td>
													<td>{{$product->unit}}</td>
												</tr>
											</tbody>
										</table>
										<div class="discription">
											<p>{{$product->description}}</p>
										</div>
									</div>
								</div>
							</div><!--END product-details-->
												@endforeach

							<!--Data table-->
							<div class="custom-data-table">
								<div class="data-table">
									<div class="heading-search">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<h2>Total Entries: {{count($data['suppliers'])}}</h2>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
											{{-- 	<form>
													<div class="searchbar-wrapper">
														<div class="searchbar">
															<i class="fas fa-search"></i>
															<input type="text" name="search" value="{{Request::get('search')}}">
														</div>
													</div>
													<button>Search</button>
											   </form> --}}
											</div>
										</div>
									</div>
									<div class="custom-table-height">
										<div class="table-responsive">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>Suplier Name</th>
														<th>Verify Suplier</th>
														<th>Phone Number </th>
														<th>Address</th>
														<th>Submit Quotation</th>
														<th>Total Amount </th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($data['suppliers'] as  $supplier)
														<!--single table row-->
														<tr>
															<td>{{$supplier['name']}}</td>
															<td> <img class="betch" src="{{asset('public/')}}/images/betch.png"> <span class="verify">{{ $supplier['is_verified'] == '1' ? 'Verify Supplier' : 'Not Verify' }}</span> </td>
															<td>{{$supplier['phone']}}</td>
															<td>{{$supplier['address']}}</td>
															<td>{{$supplier['is_submit_quotation'] == 1 ? 'Yes' : 'No'}}</td>
															<td>{{$data['tendor']->currency}} {{number_format($supplier['amount'],2)}}</td>
															<td>
																@if($supplier['is_submit_quotation'])
																     <a class="details" data-toggle="tooltip" href="{{route('vendor.quotation.details',$supplier['quotation_id'])}}">Details</a>
																@else
																     <a  data-toggle="tooltip" title="Supplier not Submitted quotation yet" class="details" href="javascript:void()" disabled>Details</a>
																@endif
															</td>
														</tr> <!--end-->
													@endforeach
												</tbody>
											</table>
										</div>
									</div>

									<!-- <div class="t-pagination clearfix">
										<div class="text-result">
											<p>Showing 1 to 1 of 1 entries</p>
										</div>
										<div class="pagination-no">
											<ul>
												<li><button>Previous</button></li>
												<li><span class="active">1</span></li>
												<li><span>2</span></li>
												<li><button>Next</button></li>
											</ul>
										</div>
									</div> -->
								</div>
							</div><!--END Data table-->
						</div><!--END my tenders-->

					</div>	
				</div>
@endsection
@push('js')
 <script type="text/javascript">
 	$('.delete-tender').on('click',function(e){
       	  e.preventDefault();

       	  	 swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this tendor!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		 })
		 .then((willDelete) => {
				if(!willDelete){
				   return false;
				}

				let data = {'id':"{{$data['tendor']->id}}"};
				$.ajax({
				"headers":{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
				},
				'type':'DELETE',
				'url' : "{{route('vendor.tendor.delete')}}",
				'data' : data,
				beforeSend: function() {

				},
				'success' : function(response){
				if(response.status == 'success'){
					 swal("Success!",response.message, "success");
					 setTimeout(function(){ window.location.href = "{{route('vendor.tendor.index')}}" }, 2000);
				}
				if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
				}
				if(response.status == 'error'){
				     console.log(response.errors);
				}
				},
				'error' : function(error){
				console.log(error);
				},
				complete: function() {

				},
				});
          });
 	});
 </script>
@endpush
