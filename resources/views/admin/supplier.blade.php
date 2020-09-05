@extends('layouts.loggedInApp')
@section('content')
    <div class="main-body">

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
                @foreach($data['suppliers'] as $key => $supplier)
                <!--single-s-request-->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="single-s-request">
                    <div class="img-text clearfix">
                      <div class="img">
                           <img src="{{$supplier->profile_image}}" onerror="profileImgError(this)">
                      </div>
                      <div class="txt">
                         <h2>{{$supplier->name}}</h2>
                         <p><i class="fas fa-map-marker-alt"></i>{{$supplier->address}}</p>
                      </div>
                    </div>
                	<div class="buttons txt">
                        <a href="{{route('admin.supplier.details',$supplier->id)}}">Details</a>
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
@endpush