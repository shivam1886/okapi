	@foreach($data['requests'] as $key => $request)
	<!--single-s-request-->
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="single-s-request">
			<div class="img-text clearfix">
				<div class="img">
					<img onerror="profileImgError(this)" src="{{$request->user->profile_image}}">
				</div>
				<div class="txt">
					<h2>{{$request->user->business_name}}</h2>
					<p><i class="fas fa-map-marker-alt"></i>{{$request->user->address}}</p>
				</div>
			</div>
			<div class="buttons">
				<button data-id="{{$request->id}}" class="accept">Accept</button>
			    <button data-id="{{$request->id}}" class="remove">Decline</button>
				<a href="{{route('vendor.supplier.show',$request->supplier_id)}}" class="details">Details</a>
			</div>
		</div>
	</div><!--END single-s-request-->
	@endforeach