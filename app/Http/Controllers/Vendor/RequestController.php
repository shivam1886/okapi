<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\SupplierRequest;
use App\Models\VendorSupplier;
use Auth;
use DB;

class RequestController extends Controller
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
       $requests = SupplierRequest::select('supplier_requests.id','supplier_requests.supplier_id','users.name','profile_image','address')->join('users','supplier_requests.supplier_id','=','users.id')
         ->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })
       ->where('vendor_id',auth::id())->get();
       if($requests->toarray()){
          foreach($requests as $key => $request){
             $requests[$key]->profile_image = $this->getImage($request->profile_image);        
          }
       }
       $data = array('requests'=>$requests);
       return view('vendor.supplier-request',compact('data'));
     }

     public function requestList(Request $request){
 $requests = SupplierRequest::select('supplier_requests.id','supplier_requests.supplier_id','users.name','profile_image','address')->join('users','supplier_requests.supplier_id','=','users.id')->where('vendor_id',auth::id())->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })->get();
       if($requests->toarray()){
          foreach($requests as $key => $request){
             $requests[$key]->profile_image = $this->getImage($request->profile_image);        
          }
       }
       $data = array('requests'=>$requests);
		return view('vendor.supplier-request-list',compact('data'));
     }

     public function accept(Request $request){
    	 $input = $request->all();
         $rules = array(
            'id'  => 'required',
         );
        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to accept request', '' , 'errors' => $validator->errors());
        }
        $supplierRequest = SupplierRequest::find($input['id']);
        $vendorSupplier  = new VendorSupplier;
        $vendorSupplier->vendor_id   = $supplierRequest->vendor_id;;
        $vendorSupplier->supplier_id = $supplierRequest->supplier_id;
        if($supplierRequest->delete() && $vendorSupplier->save()){
            $notificationId = DB::table('notifications')->insertGetId([
            'title'     => 'Request accepted',
            'sender_id' => auth::id(),
            'body'      => 'Your request has accepted by ' . auth::user()->business_name,
            'type'      => 'request',
            'meta_data' => serialize(['user_id'=>auth::id(),'request_id'=>$supplierRequest->id,'type'=>'accepet_request'])
            ]);
            $receiveId = $supplierRequest->supplier_id;
            DB::table('notification_receivers')->insert(['receiver_id'=>$receiveId,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Successully accepted request'];
        }else{
            return ['status'=>'failedd','message'=>'Failed to accept request'];
        }
     }

     public function decline(Request $request){
         $input = $request->all();
         $rules = array(
            'id'  => 'required',
         );
         // Validate 
         $validator = \Validator::make($request->all(), $rules);
         if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to decline request', '' , 'errors' => $validator->errors());
         }
           $id = $input['id'];
           $SupplierRequest = SupplierRequest::find($input['id']);
           $receiveId = $SupplierRequest->supplier_id;
         if($SupplierRequest->delete()){
            $notificationId = DB::table('notifications')->insertGetId([
            'title'     => 'Request declined',
            'sender_id' => auth::id(),
            'body'      => 'Your request has declined by ' . auth::user()->business_name,
            'type'      => 'request',
            'meta_data' => serialize(['user_id'=>auth::id(),'request_id'=>$id,'type'=>'decline_requset'])
            ]);
            $receiveId = $receiveId;
            DB::table('notification_receivers')->insert(['receiver_id'=>$receiveId,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Successully declined request'];
         }else{
            return ['status'=>'failedd','message'=>'Failed to decline request'];
         }
     }

	 public function getImage($image){
		if($image && file_exists('public/images/'.$image)){
		     return asset('public/images/'.$image);
		}
		     return asset('public/images/user-default-image.png');
	 }

      function readSupplierNotification($id = ''){
        if($id){
           $notificationData = DB::table('notification_receivers')->join('notifications','notification_receivers.notification_id','=','notifications.id')->where('receiver_id',auth::id())->where('type','request')->get();
           if($notificationData->toarray()){
                foreach ($notificationData as $key => $value) {
                    $nofityTendorId =  unserialize($value->meta_data);
                    if($id == $nofityTendorId['user_id'])
                         DB::table('notification_receivers')->where(['receiver_id'=>auth::id(),'notification_id'=>$value->id])->delete();
                }
           }
        }
      }

}
