@extends('layouts.loggedInApp')
@section('content')
    <div class="main-body">

          <!-----START searching box--------->
          <section class="searching-filter">
            <form method="GET">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input">
                    <input type="text" placeholder="Search by business name" name="search" value="{{Request::get('search')}}">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="filter-btn">
                     <a class="button" href="{{route('vendor.supplier.index')}}">Clear</a>
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
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="title">
                    <h2>Supplier List</h2>
                  </div>
                </div>
              </div>
            </div><!--END header-->

            <!--my tenders-->
            <div class="supplier-request">
              <div class="row">
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
                         <button data-id="{{$request->id}}" class="remove">Delete</button>
                         <a href="{{route('vendor.supplier.show',$request->supplier_id)}}" class="details">Details</a>
                    </div>
                  </div>
                </div><!--END single-s-request-->
                @endforeach
              </div>
            </div><!--END my tenders-->

          </div>  
        </div>
@endsection
@push('js')
 <script type="text/javascript">

      // Get Taxes
        var getSupplierList = function(){
          $.ajax(
          {
            "headers":{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
            'type':'get',
            'url' : "{{route('vendor.supplier.list')}}",
          beforeSend: function() {

          },
          'success' : function(response){
                        $('.supplier-request .row').html(response);
          },
            'error' : function(error){
          },
          complete: function() {
          },
          });
        }


    // Accept Request
   $('body').on('click','.remove',function(e){
      e.preventDefault();
          var click = $(this);
          var id    = $(this).attr('data-id');
          data      = {id:id};
         $.ajax({
          "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          'type':'DELETE',
          'url' : '{{route('vendor.supplier.remove')}}',
          'data' : data,
          beforeSend: function() {
           
          },
          'success' : function(response){
            if(response.status == 'success'){
               getSupplierList();
               swal("Success!",response.message, "success");
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

 </script>
@endpush