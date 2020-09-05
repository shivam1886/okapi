<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Tendor;
use App\Models\Department;
use App\Models\SupplierRequest;
use App\Models\VendorSupplier;
use App\Models\TendorQuotation;
use App\Models\Order;
use App\Models\TendorSupplier;
use App\Models\Product;
use DB;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('register','registerStore');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        if(auth::user()->user_type == '1'){
           $data['vendors']   = User::where('user_type','2')->count();
           $data['suppliers'] = User::where('user_type','3')->count();
           $data['supplier_vendor'] = User::where('user_type','4')->count();
        }else{

          if(auth::user()->user_type == '2' || auth::user()->user_type == '4'){

            //Tendor
            $tendors = Tendor::where('user_id',auth::id())->orderBy('id','desc')->get();
            $totalTendors = 0;
            if($tendors->toarray()){
                foreach($tendors as $key => $tendor){
                $tendor = DB::table('orders')->where('tendor_id',$tendor->id)->count();
                 if($tendor){
                   unset($tendors[$key]);
                 }else{
                    $totalTendors++;
                 }
                }
            }

            $data['tendors'] = $totalTendors;
            
            //Quotation
            $tendorQuotations = TendorQuotation::join('tendors','tendor_quotations.tendor_id','=','tendors.id')
                                               ->select('tendor_id')
                                               ->where('tendors.user_id',auth::id())
                                               ->get();
            $totalTendorQuotation = 0;
            if($tendorQuotations->toArray()){
                foreach($tendorQuotations as $key => $tendorQuotation){
                   $quotation = DB::table('orders')->where('tendor_id',$tendorQuotation->tendor_id)->count();
                   if($quotation)
                       unset($quotation[$key]);
                   else
                       $totalTendorQuotation++;
                }
            }

            $data['quotations'] = $totalTendorQuotation;

            //Supplier
            $data['suppliers'] = VendorSupplier::where('vendor_id',auth::id())->count();

            //Request
            $data['requests']  = SupplierRequest::where('vendor_id',auth::id())->count();

            //Order
            $data['orders']    = Order::where('vendor_id',auth::id())->count();

          }

          if(auth::user()->user_type == '3' || auth::user()->user_type == '4'){

             //Tendor
             $quotationData = TendorQuotation::where('supplier_id',auth::id())->whereNull('deleted_at')->get();
             $quotationTendorIds  = array_column($quotationData->toArray(), 'tendor_id');

             $orderData = Order::where('supplier_id',auth::id())->whereNull('deleted_at')->get();
             $orderTendorIds  = array_column($orderData->toArray(), 'tendor_id');

             $tendorsIds = array_merge($quotationTendorIds,$orderTendorIds);
             $data['tendors'] = TendorSupplier::where('supplier_id',auth::id())->whereNotIn('tendor_id',$tendorsIds)->count();
             
             //Vendor
              $myVendorData    = VendorSupplier::where('supplier_id',auth::id())->get();
              $myVendorIds     = array_column($myVendorData->toArray(), 'vendor_id');
              $data['vendors'] = User::where('user_type','2')->whereNotIn('id',$myVendorIds)->count();
              
              //My Vendors
              $data['my_vendors'] = VendorSupplier::where('supplier_id',auth::id())->count();
              
              //Quotation
              $data['quotations'] = TendorQuotation::where('supplier_id',auth::id())->whereNotIn('tendor_id',$orderTendorIds)->count();

              //Order
               $data['orders']    = Order::where('supplier_id',auth::id())->count();

              //Product
               $data['products']  = Product::where('user_id',auth::id())->count();

          }
        }
        return view('home',compact('data'));
    }

    public function register(Request $request){
        return view('register');
    }

    public function registerStore(Request $request){

        $input = $request->all();
        $rules = array(
            'user_type'  => 'required',
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,null,id,deleted_at,NULL',
            'phone'      => 'required|unique:users,phone,null,id,deleted_at,NULL',
            'password'   => 'required|string|confirmed|min:6',
        );

        $request->validate($rules);
        
        $password = \Hash::make($input['password']);

        $User = new User;
        $User->user_type = $input['user_type'];
        $User->name      = $input['name'];
        $User->email     = $input['email'];
        $User->phone     = $input['phone'];
        $User->latitude  = $input['latitude']  ?? 0;
        $User->longitude = $input['longitude'] ?? 0;
        $User->password  = $password;
        
        if($User->save()){
            $notifyData = [
            'sender_id' => $User->id,
            'type'      => 'register',
            'meta_data' => serialize(['user_id'=>$User->id ,'user_type' => $input['user_type']])
            ];
            if($input['user_type'] == '2' || $input['user_type'] == '4'){ 
                 $notifyData['title'] = 'New vendor';
                 $notifyData['body']  = 'A new vendor registered';
            }elseif($input['user_type'] == '3'){
                 $notifyData['title'] = 'New supplier';
                 $notifyData['body']  = 'A new supplier registered'; 
             }else{
                  $notifyData['title'] = 'New user';
                  $notifyData['body']  = 'A new user registered';
             }
                 DB::beginTransaction();
            try {
                $notificationId = DB::table('notifications')->insertGetId($notifyData);
                $notifyData['title'] = 'New Vendor & supplier';
                $notifyData['body'] = 'A new Vendor & supplier registered';
                $notificationIdAdmin = DB::table('notifications')->insertGetId($notifyData);
                DB::table('notification_receivers')->insert(['receiver_id'=>'1','notification_id'=>$notificationIdAdmin]);
                $suppliers    = User::whereIn('user_type',['3','4'])->where('id','!=',$User->id)->where('status','1')->get();
                $receiverids  = array_column($suppliers->toArray(), 'id');
                if($receiverids){
                    foreach ($receiverids as $key => $value) {
                       DB::table('notification_receivers')->insert(['receiver_id'=>$value,'notification_id'=>$notificationId]);
                    }
                }
                 DB::commit();
            } catch (\Exception $e) {
                 return $e->getMessage();
                 DB::rollback();
            }

            return redirect()->route('login')->with('status',true)->with('message','Successully registered');
        }else{
            return redirect()->route('login')->with('status',true)->with('message','Failed to register');
        }
    }

      public function changePassword(Request $request){
         $input    = $request->all();
         $rules = [
                   'old_password'      => 'required',
                   'new_password'      => 'min:6|required_with:confirm_password|same:confirm_password',
                   'confirm_password'  => 'required|min:6',
                  ];

           // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return ['status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors()];
        }

        if (!(Hash::check($request->old_password, auth()->user()->password))) {
             return ['status' => 'failed' , 'message' => 'Your old password does not matches with the current password  , Please try again'];
        }
        elseif(strcmp($request->old_password, $request->new_password) == 0){
             return ['status' => 'failed' , 'message' => 'New password cannot be same as your current password,Please choose a different new password'];
        }

         $User  = User::find(auth::id());
         $User->password = Hash::make($input['new_password']);
         if($User->update()){
           return ['status' => 'success' , 'message' => 'Successfully updated password'];
        }
           return ['status' => 'failed' , 'message' => 'Failed to update password'];
     }
}
