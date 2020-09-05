<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplierRequest;
use App\Models\VendorSupplier;
use App\Models\NotificationReceiver;
use App\User;
use auth;
use DB;

class VendorController extends Controller
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
    	$data = array();
        $latitude    = trim(auth::user()->latitude);
        $longitude   = trim(auth::user()->longitude);
    	$data['vendors'] = User::select("users.*")->selectRaw("getDistance($latitude,$longitude,latitude,longitude) as distance")
                                 ->where('users.id','!=',auth::id())->whereIn('user_type',['2','4'])
                                 ->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      });
        if($request->km){
             $data['vendors'] = $data['vendors']->orderBy('distance','asc')->get();
        }else{
            $data['vendors'] = $data['vendors']->orderBy('id','desc')->get();
        }

		if($data['vendors']->toarray()){
			foreach($data['vendors'] as $key => $vendor){
	            $isRequset = DB::table('supplier_requests')->where(['supplier_id'=>auth::id(),'vendor_id'=>$vendor->id])->count();
			   if($isRequset)
                  $data['vendors'][$key]->is_request = '1';
               else
                  $data['vendors'][$key]->is_request = '0';
			   $isRequset = DB::table('vendor_suppliers')->where(['supplier_id'=>auth::id(),'vendor_id'=>$vendor->id])->count();
			   if($isRequset){
                    unset($data['vendors'][$key]);
               }
                else{
                    if($vendor->distance){
                        $data['vendors'][$key]->distance = number_format($vendor->distance,3);
                    }
                }

                if($request->km){
                     if(empty($vendor->distance) && $vendor->distance > $request->km){
                           unset($data['vendors'][$key]);
                     }
                }
                
			}
            foreach($data['vendors'] as $key => $vendor){
               if($vendor->latitude && $vendor->longitude){
                   $data['vendors'][$key]->is_distance = '1';
               }else{
                   $data['vendors'][$key]->is_distance = '0';
               }
            }
		}
    	if($request->ajax()){
    		return view('supplier.vendor-list',compact('data'));
    	}
    	return view('supplier.vendor',compact('data'));
    }

    public function myVendor(Request $request){
        $data = array();
        $latitude    = trim(auth::user()->latitude);
        $longitude   = trim(auth::user()->longitude);
        $data['vendors'] = User::select("users.*")
                                ->selectRaw("getDistance($latitude,$longitude,latitude,longitude) as distance")
                                ->join('vendor_suppliers','users.id' , '=' ,'vendor_suppliers.vendor_id')
                                ->where('users.user_type','2')
                                ->where('vendor_suppliers.supplier_id',auth::id())
                                ->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      });
        

        if($request->km){
             $data['vendors'] = $data['vendors']->orderBy('distance','asc')->get();
        }else{
            $data['vendors'] = $data['vendors']->orderBy('vendor_suppliers.id','desc')->get();
        }

        if($data['vendors']->toArray()){
            foreach($data['vendors'] as $key => $vendor){
                    if($vendor->distance){
                      $data['vendors'][$key]->distance = number_format($vendor->distance,3);
                    }
                     if($request->km){
                         if($vendor->distance > $request->km){
                               unset($data['vendors'][$key]);
                         }
                     }
            }

            foreach($data['vendors'] as $key => $vendor){
              if($vendor->latitude && $vendor->longitude){
                   $data['vendors'][$key]->is_distance = '1';
              }else{
                   $data['vendors'][$key]->is_distance = '0';
              }
           }

        }
        if($request->ajax()){
        return view('supplier.my-vendor-list',compact('data'));
        }
        return view('supplier.my-vendor',compact('data'));
    }

    public function myVendorDetails($id){
        $data['vendor'] = User::find($id);
        $this->readUserNotification($id);
        $this->readRequestNotification($id);
        return view('supplier.my-vendor-details',compact('data'));        
    }

    public function removeVendor($id){
        if(VendorSupplier::where('supplier_id',auth::id())->where('vendor_id',$id)->delete()){
            return ['status'=>'success','message'=>'Successfully removed'];
        }else{
            return ['status'=>'failed','message'=>'Failed to remove'];
        } 
    }

    public function show($id){
    	$data['vendor'] = User::find($id);
        $isRequset = DB::table('supplier_requests')->where(['supplier_id'=>auth::id(),'vendor_id'=>$data['vendor']->id])->count();
        if($isRequset)
        $data['vendor']->is_request = '1';
        else
        $data['vendor']->is_request = '0';
        $this->readUserNotification($id);
        $this->readRequestNotification($id);
    	return view('supplier.vendor-details',compact('data'));
    }

    public function doRequest($id){
        $supplierRequest = new SupplierRequest;
        $supplierRequest->supplier_id = auth::id();
        $supplierRequest->vendor_id   = $id;
        if($supplierRequest->save()){
            $notificationId = DB::table('notifications')->insertGetId([
                    'title'     => 'You have a new request',
                    'sender_id' => auth::id(),
                    'body'      => 'You have a new request from  ' . auth::user()->business_name,
                    'type'      => 'request',
                    'meta_data' => serialize(['user_id'=>auth::id(),'request_id'=>$supplierRequest->id,'type'=>'sent_requset'])
                 ]);
              $receiveId = $id;
              DB::table('notification_receivers')->insert(['receiver_id'=>$receiveId,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Request sent'];
        }else{
            return ['status'=>'failed','message'=>'Failed to send request'];
        }
    }

    public function cancelRequest($id){
        if(SupplierRequest::where('supplier_id',auth::id())->where('vendor_id',$id)->delete()){
            return ['status'=>'success','message'=>'Successfully cancelled request'];
        }else{
            return ['status'=>'failed','message'=>'Failed to cancel request'];
        }
    }

      function readUserNotification($id = ''){
        if($id){
           $notificationData = DB::table('notification_receivers')->join('notifications','notification_receivers.notification_id','=','notifications.id')->where('receiver_id',auth::id())->where('type','register')->get();
           if($notificationData->toarray()){
                foreach ($notificationData as $key => $value) {
                    $nofityTendorId =  unserialize($value->meta_data);
                    if($id == $nofityTendorId['user_id'])
                         DB::table('notification_receivers')->where(['receiver_id'=>auth::id(),'notification_id'=>$value->id])->delete();
                }
           }
        }
      }

       function readRequestNotification($id = ''){
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
