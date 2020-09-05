@foreach($taxes as $key => $tax)
	<div class="gst add-tax">
		<form action="{{route('supplier.remove.tax')}}" method="post" id="add-tax-form" class="remove-tax-form">
			@csrf
			{{method_field('DELETE')}}
			<input type="hidden" name="id" value="{{$tax->id}}">
			<input class="tax" type="text" placeholder="title" value="{{$tax->title}}" name="title" disabled>
			<input class="percentage" type="text" pattern="[+-]?([0-9]*[.])?[0-9]+" placeholder="tax" value="{{$tax->tax}}" name="tax" disabled>
			<button style="background: #e45a63"><i class="fas fa-trash"></i></button>
		</form>
	</div>
@endforeach