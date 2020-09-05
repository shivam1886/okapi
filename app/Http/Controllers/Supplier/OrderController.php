<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\NotificationReceiver;
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
    	$orders = Order::select('orders.*')->join('users','orders.vendor_id','=','users.id')->where('supplier_id',auth::id())->where(function($query) use ($request){
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
                                  $query->where('orders.status', '=', $request->status);
                              }
                           })->get();
    	$data['orders'] = $orders;
    	if($request->ajax()){
    		return view('supplier.order-list',compact('data'));
    	}
    	return view('supplier.order',compact('data'));
    }

    public function show($id){
    	 $order = Order::find($id);
    	 $data['order'] = $order;
         $this->readOrderNotification($id);
    	 return view('supplier.order-details',compact('data'));
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
              $receiverid   = $order->vendor_id;
              DB::table('notification_receivers')->insert(['receiver_id'=>$receiverid,'notification_id'=>$notificationId]);
    		return ['status'=>'success','message'=>'Succefully submited your cancel request'];
    	}else{
    		return ['status'=>'failed','message'=>'Failed to submit your cancel request,Please try later'];
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
        return $dompdf->stream($orderId);
    }

       function readOrderNotification($id = ''){
        if($id){
           $notificationData = DB::table('notification_receivers')->join('notifications','notification_receivers.notification_id','=','notifications.id')->where('receiver_id',auth::id())->where('type','order')->get();
           if($notificationData->toarray()){
                foreach ($notificationData as $key => $value) {
                    $nofityTendorId =  unserialize($value->meta_data);
                    if($id == $nofityTendorId['order_id'])
                         DB::table('notification_receivers')->where(['receiver_id'=>auth::id(),'notification_id'=>$value->id])->delete();
                }
           }
        }
      }

}
