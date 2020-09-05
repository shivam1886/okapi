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
											<a href="index.html">Explore Tenders</a>
											<a href="myTenders_details.html"> Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Tender ID:#{{$data['tendor']->id}}</label>
									</div>
								</div>
							</div>
						</div><!--END header-->

						<!--my tenders-->
						<div class="tender-details quatation-details my-orders">
					      	<!--product-details-->
							<div class="product-details">
								
								<div class="img-text clearfix">
									<div class="img">
										<img onerror="profileImgError(this)" src="{{$data['tendor']->user->profile_image}}">
									</div>
									<div class="txt">
										<h2>{{$data['tendor']->user->business_name}}</h2>
										<p><i class="fas fa-map-marker-alt"></i>{{$data['tendor']->user->address}}</p>
									</div>
								</div>	

								<div class="close-date-wrapper">
									<label class="close-date">Close Date: {{date('d-m-Y',strtotime($data['tendor']->created_at . '+'.$data['tendor']->day.' days'))}}</label>
								</div>
								@foreach($data['tendor']->products as $product)
								<div class="single-p-details">
									<div class="table-responsive">
										<table>
											<thead>
												<tr>
													<td>Product Name</td>
													<td>Quantity</td>
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
								@endforeach
							</div><!--END product-details-->

							<!--Data table-->
							<div class="custom-data-table">
								<div class="data-table">
									<div class="heading-search">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h2>Submit Your Quotation</h2>
											</div>
										</div>
									</div>
									<form id="quotation-form" method="post" action="{{route('supplier.quotation.create')}}">
										@csrf
										<input type="hidden" name="tendor_id" value="{{$data['tendor']->id}}">
									<div class="custom-table-height">
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th>Product Name</th>
														<th>Required Quantity</th>
														<th>Per Unit Price</th>
														<th>Quantity You Provide</th>
														<th>Total Price </th>
													</tr>
												</thead>
												<tbody>
											 	  @foreach($data['tendor']->products as $product)
													<!--single table row-->
													<tr>
														<input type="hidden" name="product_id[]" value="{{$product->id}}">
														<td>{{$product->title}}</td>
														<td>{{$product->qty}}</td>
														<td> 
															<div class="price">
																<span>{{$data['tendor']->currency}}</span>
																<input class="p-price" type="text" value="" name="price[]" pattern="[+-]?([0-9]*[.])?[0-9]+" required>
															</div>
														 </td>
														<td> 
															<div class="qty">
																<input type="hidden" name="unit[]" value="{{$product->unit}}">
																<input class="p-qty" oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="text" value="" name="qty[]" required>
															</div>
														</td>
														<td> {{$data['tendor']->currency}} <span class="p-sub-total">0</span>
                                                               <input type="hidden" class="sub-total" name="sub-total[]" value="">
														</td>
													</tr> <!--end-->
													@endforeach
												</tbody>

												<tfoot>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td class="gray-bg">Estimated Total</td>
														<td class="gray-bg">{{$data['tendor']->currency}} <span id="estimated-total">0</span></td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td colspan="2">
															<div class="choose-tax">
																<select name="tax" required>
																	<option value="">Choose Tax</option>
																	@foreach($data['taxes'] as $tax)
																	      <option data-value="{{$tax->tax}}" value="{{$tax->id}}">{{$tax->title}} ({{$tax->tax}}%)</option>
																	@endforeach
																</select>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<button class="save" data-toggle="modal" data-target="#submit-quotation">Submit Quotation</button>
														</td>
														<td>
															<div class="order-status">
																<div class="lead-time">
																	<span>Lead Time</span>
																	<label>Day</label>
																	<input type="text" value="" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="lead_day" required>
																</div>
															</div>
														</td>
														<td></td>
														<td class="gray-bg">Grand  Total</td>
														<td class="gray-bg">{{$data['tendor']->currency}} <span id="grand-total">0</span></td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div><!--END Data table-->

						</div><!--END my tenders-->

					</div>	
				</div>
@endsection
@push('js')
 <script type="text/javascript">
     $('#estimated-total').text();
 	 $(function(){
        $('body').on('change','.price , .qty , select[name="tax"]',function(e){
			price    = $(this).parents('tr').find('.p-price').val() ? $(this).parents('tr').find('.p-price').val() : 0;
			qty      = $(this).parents('tr').find('.p-qty').val() ? $(this).parents('tr').find('.p-qty').val() : 0;
			priceQty = price*qty;
			$(this).parents('tr').find('.p-sub-total').text(priceQty.toFixed(2));
            $(this).parents('tr').find('.sub-total').val(priceQty.toFixed(2));
			var estimatedTotal = 0;
			$('input[name="sub-total[]"]').each(function(e){
				 if($(this).val())
                      estimatedTotal += parseFloat($(this).val());
			});
 		          $('#estimated-total').text(estimatedTotal.toFixed(2));
			tax = $('select[name="tax"]').val() ? $('select[name="tax"] option:selected').attr('data-value') : 0;
            tax = parseFloat(estimatedTotal * (tax / 100));
            estimatedTotalTax = estimatedTotal+tax;
            $('#grand-total').text(estimatedTotalTax.toFixed(2));
        })
 	 });

 	 $('body').on('submit','#quotation-form',function(e){
 	 	e.preventDefault();
 	  	  var click = $(this);
       	  let form = $(this);
          let data = form.serialize();
         $.ajax({
          "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          'type':'POST',
          'url' : form.attr('action'),
          'data' : data,
          beforeSend: function() {
           
          },
          'success' : function(response){
            click.find('span').hide();
          	if(response.status == 'success'){
 				 swal("Success!",response.message, "success");
  			     setTimeout(function(){ window.location.href = "{{route('supplier.quotation.index')}}" }, 1000);
          	}
          	if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
          	}
        	$('#add-department-form input').val('');
        	if(response.status == 'error'){
	             $.each(response.errors, function (key, val) {
				    click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
				 });
        	}
          },
         'error' : function(error){
          console.log(error);
         },
          complete: function() {
               
             },
         });
 	 })
 </script>
@endpush