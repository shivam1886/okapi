<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Dompdf\Dompdf;
use Auth;
use DB;

class OrderController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request){
    	$orders = Order::select('orders.*')->join('users','orders.supplier_id','=','users.id')
                         ->where(function($query) use ($request){
                              if($request->search){
                                  $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                              }
                              if($request->day){
                                  $query->whereDay('orders.created_at', '=', $request->day);
                              }
                              if($request->month){
                                  $query->whereMonth('orders.created_at', '=', $request->month);
                              }
                              if($request->year){
                                  $query->whereYear('orders.created_at', '=', $request->year);
                              }
                              if($request->status){
                                  $query->whereYear('orders.status', '=', $request->status);
                              }
                         })->where('vendor_id',auth::id())->get();
        $data['orders'] = $orders;
    	if($request->ajax()){
    		return view('vendor.order-list',compact('data'));
    	}
    	return view('vendor.order',compact('data'));
    }

    public function show($id){
    	 $order = Order::find($id);
    	 $data['order'] = $order;
    	 return view('vendor.order-details',compact('data'));
    }

    public function cancelOrder(Request $request,$id){
    	$input = $request->all();
    	
    	$rules = array(
            'reason'  => 'required|string',
        );

        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors());
        }

    	$order = Order::find($id);
    	$order->status = '4';
    	$order->cancel_user_id = auth::id();
    	$order->cancel_reason  = $input['reason'];
    	$order->cancel_date    = date('Y-m-d');
    	if($order->update()){
              $notificationId = DB::table('notifications')->insertGetId([
                    'title'     => 'Order cancel',
                    'sender_id' => auth::id(),
                    'body'      => 'Your order is cancel by ' . auth::user()->business_name,
                    'type'      => 'order',
                    'meta_data' => serialize(['order_id'=>$id])
                 ]);
              $receiverid   = $order->supplier_id;
              DB::table('notification_receivers')->insert(['receiver_id'=>$receiverid,'notification_id'=>$notificationId]);
    		return ['status'=>'success','message'=>'Succefully submited your cancel request'];
        }
    	else{
    		return ['status'=>'failed','message'=>'Failed to submit your cancel request,Please try later'];
        }
    }

    public function receivedOrder($id){
       $order = Order::find($id);
       $order->status = '5';
       $order->received_date = date('Y-m-d H:i:s');
       if($order->update()){
            $notificationId = DB::table('notifications')->insertGetId([
            'title'     => 'Order Received',
            'sender_id' => auth::id(),
            'body'      => 'Your order is received by ' . auth::user()->business_name,
            'type'      => 'order',
            'meta_data' => serialize(['order_id'=>$id])
            ]);
            $receiverid   = $order->supplier_id;
            DB::table('notification_receivers')->insert(['receiver_id'=>$receiverid,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Succefully updated order status'];
       }else{
            return ['status'=>'failed','message'=>'Failed to update order status'];
       }
    }

    public function changeOrder(Request $request,$id){
       $input = $request->all();
       $order = Order::find($id);
       $order->status = $input['status'];
        if($input['status'] == '1'){
          $text = 'processing';
          $order->processing_date = date('Y-m-d H:i:s');
        }
        elseif($input['status'] == '2'){
          $text = 'dispatch';
          $order->dispatch_date = date('Y-m-d H:i:s');
        }
        elseif($input['status'] == '3'){
          $text  = 'delivered';
          $order->delivered_date = date('Y-m-d H:i:s');
        }
        elseif($input['status'] == '4'){
          $text  = 'cancelled';
          $order->cancel_date = date('Y-m-d H:i:s');
        }
        else{
          $text  = '';
        }

       if($order->update()){
            $notificationId = DB::table('notifications')->insertGetId([
            'title'     => 'Order ' . $text,
            'sender_id' => auth::id(),
            'body'      => 'Your order is '.$text.' by ' . auth::user()->business_name,
            'type'      => 'order',
            'meta_data' => serialize(['order_id'=>$id])
            ]);
            $receiverid   = $order->vendor_id;
            DB::table('notification_receivers')->insert(['receiver_id'=>$receiverid,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Succefully updated order status'];
       }else{
            return ['status'=>'failed','message'=>'Failed to update order status'];
       }
    }

    public function pdf($id){
        $data['order'] = Order::find($id);
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html   = view('vendor.order_pdf',compact('data'));
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
       $dompdf->render();
        // Output the generated PDF to Browser
        $orderId = date('Ymd') . $data['order']->id;
        return $dompdf->stream();
    }
}
