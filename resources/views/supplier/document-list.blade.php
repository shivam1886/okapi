@foreach($documents as $key => $document)
<!--single-document-->
<div class="single-document">
	<p>&nbsp;</p>
	<label class="img">
		<input type="file">
		<img src="{{$document->document}}">
	</label>
</div><!--end-->
@endforeach