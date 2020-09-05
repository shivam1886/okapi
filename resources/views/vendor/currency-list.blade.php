@foreach($data['currency'] as $currency)
	<div class="gst add-tax">
		<form action="{{route('vendor.currency.destroy',$currency->id)}}" method="post" id="dlt-currency-form">
			@csrf
			{{ method_field('DELETE')}}
			<input class="tax" type="text" placeholder="currency" value="{{$currency->title}}" name="currency" readonly>
			<button style="background: #e45863"><i class="fas fa-trash"></i></button>
		</form>
	</div>
@endforeach