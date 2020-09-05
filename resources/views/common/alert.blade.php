 @if(Session::get('message'))
  <div class="alert @if(Session::get('status')) {{ 'alert-success' }} @else {{ 'alert-danger' }} @endif" role="alert">
    <i class="fa @if(Session::get('status')) fa-check @else fa-times @endif mx-2"></i>
    {{Session::get('message')}}
 </div>
 @endif