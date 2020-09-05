<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\SupplierRequest;
use App\Models\VendorSupplier;
use Auth;
use DB;

class SupplierController extends Controller
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
       $requests = VendorSupplier::select('vendor_suppliers.id','vendor_suppliers.supplier_id','users.name','profile_image','address')
                              ->join('users','vendor_suppliers.supplier_id','=','users.id')
                              ->where('vendor_id',auth::id())
                              ->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })
                              ->get();
       if($requests->toarray()){
          foreach($requests as $key => $request){
             $requests[$key]->profile_image = $this->getImage($request->profile_image);        
          }
       }
       $data = array('requests'=>$requests);
       return view('vendor.supplier',compact('data'));
     }

     public function suppliertList(Request $request){
 $requests = VendorSupplier::select('vendor_suppliers.id','vendor_suppliers.supplier_id','users.name','profile_image','address')->join('users','vendor_suppliers.supplier_id','=','users.id')->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })->where('vendor_id',auth::id())->get();
       if($requests->toarray()){
          foreach($requests as $key => $request){
             $requests[$key]->profile_image = $this->getImage($request->profile_image);        
          }
       }
       $data = array('requests'=>$requests);
		return view('vendor.supplier-list',compact('data'));
     }

     public function show($id){
        $user = User::find($id);
        $this->readUserNotification($id);
        return view('vendor.supplier-details',compact('user'));
     }

     public function remove(Request $request){
         $input = $request->all();
         $rules = array(
            'id'  => 'required',
         );
         // Validate 
         $validator = \Validator::make($request->all(), $rules);
         if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to delete supplier', '' , 'errors' => $validator->errors());
         }
         $vendorSupplier = VendorSupplier::find($input['id']);
         if($vendorSupplier->delete()){
            return ['status'=>'success','message'=>'Successully deleted supplier'];
         }else{
            return ['status'=>'failedd','message'=>'Failed to delete supplier'];
         }
     }

	 public function getImage($image){
		if($image && file_exists('public/images/'.$image)){
		     return asset('public/images/'.$image);
		}
		     return asset('public/images/user-default-image.png');
	 }

      function readUserNotification($id = ''){
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
