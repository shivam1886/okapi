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
											<a href="my_quotation.html">My Quotation</a>
											<a href="myQuotation_details.html"> Details</a>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text">
										<label class="id">Tender ID:#{{$data['quotation']->tendor->id}}</label>
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
										<img onerror="profileImgError(this)" src="{{$data['quotation']->tendor->user->profile_image}}">
									</div>
									<div class="txt">
										<h2>{{$data['quotation']->tendor->user->business_name}}</h2>
										<p><i class="fas fa-map-marker-alt"></i>  Sectore 34 Lorem Ipsum Dummy Indore India</p>
									</div>
								</div>	

								<div class="close-date-wrapper">
									<label class="close-date">Close Date: {{date('d-m-Y',strtotime($data['quotation']->tendor->created_at . '+'.$data['quotation']->tendor->day.' days'))}}</label>
								</div>
								@foreach($data['quotation']->tendor->products  as $product)
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
							<form id="quotation-form" method="post" action="{{route('supplier.quotation.update',$data['quotation']->id)}}">
								@csrf
								{{ method_field('PUT')}}
								<input type="hidden" name="tendor_id" value="{{$data['quotation']->tendor_id}}">
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
														@php $totalEstimatePrice = 0;@endphp
														@foreach($data['quotation']->quotationProduct as $product)
														<input type="hidden" name="product_id[]" value="{{$product->product_id}}">
														<!--single table row-->
														<tr>
															<td>{{$product->product->title}}</td>
															<td>{{$product->product->qty}}</td>
															<td>
																<div class="price">
																	<span>{{$data['quotation']->tendor->currency}}</span>
																	<input class="p-price" type="text" value="{{$product->price}}" pattern="[+-]?([0-9]*[.])?[0-9]+" name="price[]">
																</div>
															 </td>
															<td>
															    <div class="qty">
																	<input type="hidden" name="unit[]" value="{{$product->unit}}">														
																	<input class="p-qty" oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="text" value="{{$product->qty}}" name="qty[]">
																</div>
															</td>
															@php $totalEstimatePrice += $product->qty*$product->price @endphp
															<td> {{$data['quotation']->tendor->currency}} <span class="p-sub-total">{{$product->qty*$product->price}}</span>
															    <input type="hidden" class="sub-total" name="sub-total[]" value="{{$product->qty*$product->price}}">
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
															<td class="gray-bg">
																{{$data['quotation']->currency}} <span class="p-sub-total" id="estimated-total">{{$totalEstimatePrice}}</span>
															</td>
														</tr>
														<tr>
															<td></td>
															<td></td>
															<td></td>
															<td colspan="2">
																<div class="choose-tax">
																	<select name="tax">
																		<option value="">Choose Tax</option>
																		@foreach($data['taxes'] as $tax)
																		      <option @if($data['quotation']->tax->id == $tax->id) selected @endif data-value="{{$tax->tax}}" value="{{$tax->id}}">{{$tax->title}} ({{$tax->tax}}%)</option>
																		@endforeach
																	</select>
																</div>
															</td>
														</tr>
														<tr>
															<td>
																<div class="order-status">
																	@if($data['quotation']->status != '2')
																		<button class="status received-price cancel">Cancel Quotation</button>
																		<button class="save edit-quotation"">Edit Quotation</button>
																	    <button class="save update-quotation-btn">Update Quotation</button>
																		<button class="status cancel-update">Cancel Update</button>
																    @else
                                                                        <p class="text-danger">This quotation is cancelled</p>
																	@endif
																</div>
															</td>
															<td>
																<div class="order-status" style="width:100px;">
																	<div class="lead-time">
																		<span style="font-size: 13px !important;">Lead Time</span>
																		<label>Day</label>
																		<input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$data['quotation']->lead_day}}" name="lead_day">
																	</div>
																</div>
															</td>
															<td></td>
															@php 
															     $totalPrice = 0;
	                                                             $totalPrice = $totalEstimatePrice + ($totalEstimatePrice * $data['quotation']->tax->tax/100);
															@endphp
															<td class="gray-bg">Grand  Total</td>
															<td class="gray-bg">{{$data['quotation']->tendor->currency}} <span id="grand-total">{{$totalPrice}}</span></td>
														</tr>
												
													</tfoot>
												</table>
											@if($data['quotation']->status == '2')
													<div class="table-responsive">
												<table class="table">
												<tr>
													<td>
														<div class="note">
														<span>Cancel Reason*</span>
															<div class="row">
															<div class="col-md-6 col-sm-6 col-xs-12">
															<span>	Cancel By
															@if($data['quotation']->cancel_user_id != auth::id()) Vendor @else You @endif
															</span>
															</div>
																<div class="col-md-6 col-sm-6 col-xs-12 text-right">
																<span>Date : {{ date('Y-M-d',strtotime($data['quotation']->cancel_date))}}</span>
																</div>
															</div>
														   <p>{{$data['quotation']->cancel_reason}}</p>
														</div>
													</td>
												</tr>
												</table>
												@endif
											</div>
										</div>
									</div>
								</div><!--END Data table-->
						    </form>

						</div><!--END my tenders-->

					</div>

					  <!-- Modal -->
  <div class="modal fade" id="cancelQuotationModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
         <form action="{{route('supplier.quotation.cancel',$data['quotation']->id)}}" method="post" id="cancelModalForm">
        	@csrf
            {{ method_field('PUT')}}
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Cancel Quotation</h4>
		        </div>
		        <div class="modal-body">
		        	<p>Why are you cancel this quotation?</p>
		          	<div class="form-group">
		          		<textarea class="form-control" placeholder="Please give reason" name="reason" required></textarea>
		          	</div>
		        </div>
		        <div class="modal-footer">
		          <button type="submit" class="btn" style="background: #e45a63;color:#fff">Confirm</button>
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
         </form>
      
    </div>
  </div>

				</div>
@endsection
@push('css')
 <style type="text/css">
	.edit-hide{
		border: none !important;
		background: white !important;
		color: black !important;
		pointer-events: none !important;
	}
	.update-quotation-btn{
		display: none;
	}
 </style>
@endpush
@push('js')
 <script type="text/javascript">

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

 	$('.price span,input,qty input,.choose-tax,.lead-time span,.lead-time input').addClass('edit-hide');
 	$('.cancel-update').hide();
 	$('.edit-quotation').on('click',function(e){
 		e.preventDefault();
  		$(this).hide();
  		$('.update-quotation-btn').show();
  		$('.cancel-update').show();
 		$('.received-price').hide();
  	    $('.price span,input,qty input,.choose-tax').removeClass('edit-hide');
 	})

 	$('.cancel-update').on('click',function(e){
          e.preventDefault();
          window.location.reload();
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
          	if(response.status == 'success'){
 				 swal("Success!",response.message, "success");
  			     setTimeout(function(){ window.location.reload() }, 1500);
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

 	 $('body').on('click','.cancel',function(e){
 	 	e.preventDefault();
 	 	$('#cancelQuotationModal').modal('show');
 	 });

 	  $('body').on('submit','#cancelModalForm',function(e){
         e.preventDefault();
         var click = $('#cancelQuotationModal');
         let form = $(this);
         let data = form.serialize();
         $.ajax({
          "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          'type':'PUT',
          'url' : form.attr('action'),
          'data' : data,
          beforeSend: function() {
           
          },
          'success' : function(response){
          	click.modal('hide');
        	click.find('textarea').val('');
			click.find('span').hide();
          	if(response.status == 'success'){
 				 swal("Success!",response.message, "success");
 				 setTimeout(function(){ location.reload(); }, 1000);
          	}
          	if(response.status == 'failed'){
				 swal("Success!",response.message, "error");
          	}
        	if(response.status == 'error'){
				$.each(response.errors, function (key, val) {
				click.find('[name='+key+']').after('<span style="color:red">'+val+'</span>');
				$('.'+key).after('<br><span style="color:red">'+val+'</span>');
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