<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TendorQuotation;
use App\Models\NotificationReceiver;
use App\Models\Tax;
use auth;
use DB;

class QuotationController extends Controller
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
	      $quotations =  TendorQuotation::select('tendor_quotations.*')->join('tendors','tendor_quotations.tendor_id','=','tendors.id')->join('users','tendors.user_id','=','users.id')->where('supplier_id',auth::id())->orderBy('id','desc')->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })->get();
	      $data = array('quotations'=>$quotations);
	   	  return view('supplier.quotation',compact('data'));
     }    

      public function show(Request $request,$id){
	      $quotation =  TendorQuotation::find($id);
	      $taxes     = Tax::where('user_id',auth::id())->get();
	      $data = array('quotation'=>$quotation,'taxes'=>$taxes);
        if($request->notification_id){
            NotificationReceiver::where(['receiver_id'=>auth::id(),'notification_id'=>$request->notification_id])->update(['is_read'=>'1']);
         }
         $this->readTendorNotification($id);
	   	  return view('supplier.quotation-details',compact('data'));
      }

      public function update(Request $request,$id){
      	 $input = $request->all();
    	 $productData   = array();
    	 $quotationData = array();
         DB::beginTransaction();
         try {
			DB::table('tendor_quotations')->where('id',$id)->update(['tendor_id'=>$input['tendor_id'],'supplier_id'=>auth::id(),'lead_day'=>$input['lead_day'],'tax_id'=>$input['tax']]);
			foreach($input['product_id'] as $key =>  $product){
			DB::table('tendor_quotation_products')->where(['tendor_id'=>$input['tendor_id'],'supplier_id'=>auth::id(),'product_id'=>$input['product_id'][$key]])->update(['qty'=>$input['qty'][$key],'price'=>$input['price'][$key],'unit'=>$input['unit'][$key]]);
			}
			DB::commit();
            return ['status'=>'success','message'=>'Successfully updated quotation'];
         } catch (Exception $e) {
            DB::rollback();
            return ['status'=>'failed','message'=>'Failed to update quotation'];
         }
      }

      public function quotationCancel(Request $request,$id){
         $input = $request->all();
         $TendorQuotation = TendorQuotation::find($id);
         $TendorQuotation->cancel_user_id = auth::id();
         $TendorQuotation->cancel_reason  = $input['reason'];
         $TendorQuotation->cancel_date    = date('Y-m-d H:i:s');
         $TendorQuotation->status = '2';
         if($TendorQuotation->update()){
           $notificationId = DB::table('notifications')->insertGetId([
            'title'     => 'Quotation is cancelled',
            'sender_id' => auth::id(),
            'body'      => 'Quotation is cancelled by ' . auth::user()->business_name,
            'type'      => 'quotation',
            'meta_data' => serialize(['quotation_id'=>$id])
                 ]);
            $receiverid   = $TendorQuotation->tendor->user_id;
            DB::table('notification_receivers')->insert(['receiver_id'=>$receiverid,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Successfully cancel tendor'];
         }else
            return ['status'=>'failed','message'=>'Failed to cancel tendor'];
      }

       function readTendorNotification($id = ''){
        if($id){
           $notificationData = DB::table('notification_receivers')->join('notifications','notification_receivers.notification_id','=','notifications.id')->where('receiver_id',auth::id())->where('type','quotation')->get();
           if($notificationData->toarray()){
                foreach ($notificationData as $key => $value) {
                    $nofityTendorId =  unserialize($value->meta_data);
                    if($id == $nofityTendorId['quotation_id'])
                         DB::table('notification_receivers')->where(['receiver_id'=>auth::id(),'notification_id'=>$value->id])->delete();
                }
           }
        }
      }
}
