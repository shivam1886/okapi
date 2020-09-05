<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tendor;
use App\Models\TendorSupplier;
use App\Models\TendorQuotation;
use App\Models\NotificationReceiver;
use auth;
use DB;

class TendorController extends Controller
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

    	$quotationTendors = TendorQuotation::select('tendor_id')
                           ->where('supplier_id',auth::id())->orderBy('id','desc')->get();
    	$quotationTendorIds = array_column($quotationTendors->toArray(), 'tendor_id');
	    $tendors = TendorSupplier::select('tendor_suppliers.*')->join('tendors','tendor_suppliers.tendor_id','=','tendors.id')
                                  ->join('users','tendors.user_id','=','users.id')
                                  ->where('supplier_id',auth::id())->whereNotIn('tendor_id',$quotationTendorIds)->orderBy('tendor_suppliers.id','desc')->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })->get();
        $tendors = Tendor::whereIn('id',array_column($tendors->toarray(), 'tendor_id'))->get();
    	$data = array('tendors'=>$tendors);
    	return view('supplier.tendor',compact('data'));
    }

    public function show(Request $request,$id){
    	$tendor = Tendor::find($id);
    	$taxes  = DB::table('taxes')->where('user_id',auth::id())->whereNull('deleted_at')->get();
    	$data = array('tendor'=>$tendor,'taxes'=>$taxes);
        $this->readNotification($id);
    	return view('supplier.tendor-details',compact('data'));
    }

    public function submitQuotation(Request $request){
    	$input = $request->all();
    	$productData   = array();
    	$quotationData = array();
        DB::beginTransaction();
        try {
			$quotationID = DB::table('tendor_quotations')->insertGetId(['tendor_id'=>$input['tendor_id'],'supplier_id'=>auth::id(),'lead_day'=>$input['lead_day'],'tax_id'=>$input['tax']]);
			foreach($input['product_id'] as $key =>  $product){
			DB::table('tendor_quotation_products')->insert(['quotation_id' => $quotationID , 'tendor_id'=>$input['tendor_id'],'supplier_id'=>auth::id(),'product_id'=>$input['product_id'][$key],'qty'=>$input['qty'][$key],'price'=>$input['price'][$key],'unit'=>$input['unit'][$key]]);
			}
             $tendorId = $input['tendor_id'];
             $notificationId = DB::table('notifications')->insertGetId([
                    'title'     => 'You have a new submission tendor request',
                    'sender_id' => auth::id(),
                    'body'      => 'You have a new submission tendor request by ' . auth::user()->business_name,
                    'type'      => 'quotation',
                    'meta_data' => serialize(['tendor_id'=>$tendorId ,'quotation_id'=>$quotationID])
                 ]);
              $tendorData = Tendor::find($tendorId);
              $senderid   = $tendorData->user_id;
              DB::table('notification_receivers')->insert(['receiver_id'=>$senderid,'notification_id'=>$notificationId]);
			  DB::commit();
            return ['status'=>'success','message'=>'Successfully submitted quotation'];
        } catch (Exception $e) {
            DB::rollback();
            return ['status'=>'failed','message'=>'Failed to submit quotation'];
        }
    }

    function readNotification($tendorId = ''){
        if($tendorId){
           $notificationData = DB::table('notification_receivers')->join('notifications','notification_receivers.notification_id','=','notifications.id')->where('receiver_id',auth::id())->where('type','tendor')->get();
           if($notificationData->toarray()){
                foreach ($notificationData as $key => $value) {
                    $nofityTendorId =  unserialize($value->meta_data);
                    if($tendorId == $nofityTendorId['tendor_id'])
                         DB::table('notification_receivers')->where(['receiver_id'=>auth::id(),'notification_id'=>$value->id])->delete();
                }
           }

        }
    }
}
