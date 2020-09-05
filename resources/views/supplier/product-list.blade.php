@foreach($data['products'] as $product)
<!--single-->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="single-pc" data-id="{{$product->id}}">
			<h2>{{$product->title}}</h2>
			<div class="price">
				<p>Price: <span>{{$product->currency}} {{$product->price}}</span></p>
			</div>
		</div>
	</div><!--END-->
@endforeach