<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VendorSupplier;
use App\Models\QuotationProduct;
use App\Models\TendorQuotation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\NotificationReceiver;
use Dompdf\Dompdf;
use auth;
use DB;
use App\Models\Tendor;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tendors = Tendor::select('tendors.*')
                           ->join('users','tendors.user_id','=','users.id')
                           ->where('user_id',auth::id())
                           ->where(function($query) use ($request){
                              if($request->day){
                                  $query->whereDay('tendors.created_at', '=', $request->day);
                              }
                              if($request->month){
                                  $query->whereMonth('tendors.created_at', '=', $request->month);
                              }
                              if($request->year){
                                  $query->whereYear('tendors.created_at', '=', $request->year);
                              }
                           })
                   ->orderBy('id','desc')->get();
        if($tendors->toarray()){
            foreach($tendors as $key => $tendor){
                $tendor = DB::table('orders')->where('tendor_id',$tendor->id)->count();
                if($tendor)
                    unset($tendors[$key]);
            }
        }
        $data = array('tendors'=>$tendors);
        return view('vendor.tendor',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = VendorSupplier::where('vendor_id',auth::id())->get();
        $data = array('suppliers'=>$suppliers);
        return view('vendor.tendor-add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $tendorData   = array();
        $productData  = array();
        $supplierData = array();

        $tendorData['currency'] = $input['currency'];
        $tendorData['user_id']  = auth::id();
        $tendorData['day']       = $input['day'];
        
        $totalProduct = count($input['title']);
        $title = $input['title'];
        $qty   = $input['qty'];
        $description = $input['description'];
        DB::beginTransaction();
        try {
             $tendorId = DB::table('tendors')->insertGetId($tendorData);

             if($totalProduct != 0 && count($title) == $totalProduct && count($qty) == $totalProduct && count($description) == $totalProduct){
                foreach($title as $key => $value){
                  array_push($productData, ['tendor_id'=> $tendorId , 'title'=>$input['title'][$key],'qty'=>$input['qty'][$key],'unit'=>$input['unit'][$key],'description'=>$input['description'][$key]]);
                }
             }
            
             if(isset($input['suppliers']) && count($input['suppliers'])){
                foreach($input['suppliers'] as $key => $value){
                  array_push($supplierData, ['tendor_id'=>$tendorId,'supplier_id'=>$input['suppliers'][$key]]);
                }
             }
            
             if($productData)
                DB::table('tendor_products')->insert($productData);
            
             if($supplierData)
                DB::table('tendor_suppliers')->insert($supplierData);
 
             if(isset($input['suppliers']) && count($input['suppliers'])){
                 $notificationId = DB::table('notifications')->insertGetId([
                    'title'     => 'You have a new tendor',
                    'sender_id' => auth::id(),
                    'body'      => 'You have a new tendor by ' . auth::user()->business_name,
                    'type'      => 'tendor',
                    'meta_data' => serialize(['tendor_id'=>$tendorId])
                 ]);

                  $notificationsReciverdata = array();
                    foreach($input['suppliers'] as $key => $value){
                      array_push($notificationsReciverdata, ['receiver_id'=>$input['suppliers'][$key],'notification_id'=>$notificationId]);
                  }
                  DB::table('notification_receivers')->insert($notificationsReciverdata);
              }

                DB::commit();
                return ['status'=>'success','message'=>'Successfully added tendor'];
        } catch (Exception $e) {
                DB::rollBack();
                return ['status'=>'failed','message'=>'Failed to add tendor'];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $tendor = Tendor::find($id);
        $suppliers = array();
        if($tendor->suppliers){
            foreach ($tendor->suppliers as $key => $value) {
                $suppliers[$key]['supplier_id'] = $value->user->id;
                $suppliers[$key]['name'] = $value->user->business_name;
                $suppliers[$key]['is_verified'] = $value->user->is_verified;
                $suppliers[$key]['phone'] = $value->user->phone;
                $suppliers[$key]['email'] = $value->user->email;
                $suppliers[$key]['address'] = $value->user->address;
              $quotationData =   QuotationProduct::where('tendor_id',$value->tendor_id)
                                 ->where('supplier_id',$value->supplier_id)
                                 ->get();
              if($quotationData->toArray()){
                    $amount = 0;
                    $suppliers[$key]['quotation_id'] = $quotationData[0]->quotation_id;
                       $suppliers[$key]['is_submit_quotation'] = '1';
                    foreach($quotationData as $quotation){
                        $amount += $quotation->qty * $quotation->price;
                        $suppliers[$key]['amount'] = $amount;
                    }
              }else{
                        $suppliers[$key]['quotation_id'] = '0';
                        $suppliers[$key]['is_submit_quotation'] = '0';
                        $suppliers[$key]['amount'] = 0;
              }
            }
        }
        $data = array('tendor'=>$tendor,'suppliers'=>$suppliers);
        return view('vendor.tendor-details',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers = VendorSupplier::where('vendor_id',auth::id())->get();
        $tendor    = Tendor::find($id);
        $selectedSuppliers =  array_column($tendor->suppliers->toArray(), 'supplier_id');
        if($suppliers->toArray()){
            foreach ($suppliers as $supplier_key => $supplier) {
                 if(in_array($supplier->supplier_id,$selectedSuppliers))
                      $suppliers[$supplier_key]->selected = true;
                 else
                      $suppliers[$supplier_key]->selected = false;
            }
        }
        $data = array('suppliers'=>$suppliers,'tendor'=>$tendor);
        return view('vendor.tendor-edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $tendorData   = array();
        $supplierData = array();
        
        $tendorId               = $id;
        $tendorData['currency'] = $input['currency'];
        $tendorData['user_id']  = auth::id();
        $tendorData['day']      = $input['day'];
        
        $totalProduct = count($input['title']);
        $productids   = $input['product_id'];
        $title = $input['title'];
        $qty   = $input['qty'];
        $description = $input['description'];
        $supplierIds   = $input['suppliers'] ?? [];
        DB::beginTransaction();
        try {

              DB::table('tendors')->where('id',$tendorId)->update($tendorData);
              DB::table('tendor_products')->where('tendor_id',$tendorId)->whereNotIn('id',array_filter($productids,function($value){ return !is_null($value);}))->delete();
            //  DB::table('tendor_suppliers')->where('tendor_id',$tendorId)->whereNotIn('supplier_id',array_filter($supplierIds,function($value){ return !is_null($value);}))->delete();
              DB::table('tendor_suppliers')->where('tendor_id',$tendorId)->delete();
             if($totalProduct != 0 && count($title) == $totalProduct && count($qty) == $totalProduct && count($description) == $totalProduct){
                foreach($title as $key => $value){
                  if($productids[$key]){
                     DB::table('tendor_products')->where('id',$productids[$key])->update(['tendor_id'=> $tendorId , 'title'=>$input['title'][$key],'qty'=>$input['qty'][$key],'unit'=>$input['unit'][$key],'description'=>$input['description'][$key]]);
                  }
                  else{
                      DB::table('tendor_products')->insert(['tendor_id'=> $tendorId , 'title'=>$input['title'][$key],'qty'=>$input['qty'][$key],'description'=>$input['description'][$key]]);
                  } 

                }
             }
            
             if($supplierIds){
                $supplierData = array();
                foreach($supplierIds as $key => $value){
                    array_push($supplierData,['tendor_id'=>$tendorId,'supplier_id'=>$value]);
                }
                    DB::table('tendor_suppliers')->insert($supplierData);
             }
                if(isset($input['suppliers']) && count($input['suppliers'])){
                 $notificationId = DB::table('notifications')->insertGetId([
                    'title'     => 'You have a new tendor',
                    'sender_id' => auth::id(),
                    'body'      => 'You have a new tendor by ' . auth::user()->business_name,
                    'type'      => 'tendor',
                    'meta_data' => serialize(['tendor_id'=>$tendorId])
                 ]);

                  $notificationsReciverdata = array();
                    foreach($input['suppliers'] as $key => $value){
                      array_push($notificationsReciverdata, ['receiver_id'=>$input['suppliers'][$key],'notification_id'=>$notificationId]);
                  }
                  DB::table('notification_receivers')->insert($notificationsReciverdata);
              }
                DB::commit();
                return ['status'=>'success','message'=>'Successfully updated tendor'];
        } catch (Exception $e) {
                DB::rollBack();
                return ['status'=>'failed','message'=>'Failed to update tendor'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         if(Tendor::find($request->id)->delete()){
             return ['status'=>'success','message'=>'Successfully deleted tendor'];
         }else{
             return ['status'=>'failed','message'=>'Failed delete tendor'];
         }
    }

    public function quotationSupplierDetails(Request $request,$id){
        $data['quotation'] = TendorQuotation::find($id);
        if($request->notification_id){
            NotificationReceiver::where(['receiver_id'=>auth::id(),'notification_id'=>$request->notification_id])->update(['is_read'=>'1']);
         }
         $this->readTendorNotification($id);
        return view('vendor.quotation-supplier-details',compact('data'));
    }

    public function quotationAccept($id){
       
       $orderData   = array();
       $orderItems  = array();
       
       $quotation   = TendorQuotation::find($id);
       
       $supplierId  = $quotation->supplier_id;
       $orderData['tendor_id']    = $quotation->tendor_id;
       $orderData['quotation_id'] = $quotation->id;
       $orderData['supplier_id']  = $quotation->supplier_id;
       $orderData['vendor_id']    = auth::id();
       $orderData['lead_day']     = $quotation->lead_day;
       $orderData['currency']     = $quotation->tendor->currency;
       $orderData['close_day']    = $quotation->tendor->day;
       $orderData['tax_title']    = $quotation->tax->title;
       $orderData['tax']          = $quotation->tax->tax;
       $orderData['tendor_date']  = date('Y-m-d',strtotime($quotation->tendor->created_at));
        
        $orderId = '7';

          DB::beginTransaction();
        try {
          $orderId = DB::table('orders')->insertGetId($orderData);
            foreach($quotation->quotationProduct as $quotationProduct){
                 $temp = array();
                 $temp['order_id']     = $orderId;
                 $temp['title']        = $quotationProduct->product->title;
                 $temp['description']  = $quotationProduct->product->description;
                 $temp['required_qty'] = $quotationProduct->product->qty;
                 $temp['supply_qty']   = $quotationProduct->qty;
                 $temp['price']        = $quotationProduct->price;
                 array_push($orderItems,$temp);
            }
          DB::table('order_items')->insert($orderItems);
          DB::table('tendors')->where('id',$orderData['tendor_id'])->update(['status'=>'1']);
          DB::table('tendor_quotations')->where('supplier_id',$orderData['supplier_id'])->where('id',$orderData['tendor_id'])->update(['status'=>'1']);

          $notificationId = DB::table('notifications')->insertGetId([
              'title'     => 'Quotation is accepted',
              'sender_id' => auth::id(),
              'body'      => 'Quotation accepted by ' . auth::user()->business_name,
              'type'      => 'order',
              'meta_data' => serialize(['order_id'=>$orderId])
          ]);
          $receiverid   = $supplierId;
          DB::table('notification_receivers')->insert(['receiver_id'=>$receiverid,'notification_id'=>$notificationId]);
          DB::commit();
          $quotation->status = '1';
          $quotation->update();
          return ['status'=>'success','message'=>'Successfully accepted quotation'];
        } catch (Exception $e) {
                DB::rollBack();
                return ['status'=>'failed','message'=> $e->getMessage()];
        }

    }
    public function quotationReject(Request $request,$id){
        $TendorQuotation = TendorQuotation::find($id);
        $TendorQuotation->status = '2';
        $TendorQuotation->cancel_user_id = auth::id();
        $TendorQuotation->cancel_reason  = $request->reason;
        $TendorQuotation->cancel_date    = date('Y-m-d H:i:s');
        if($TendorQuotation->update()){
            $notificationId = DB::table('notifications')->insertGetId([
                    'title'     => 'Your quotation is rejected',
                    'sender_id' => auth::id(),
                    'body'      => 'Your quotation is rejected by ' . auth::user()->business_name,
                    'type'      => 'quotation',
                    'meta_data' => serialize(['quotation_id'=>$id])
                 ]);
              $senderid   = $TendorQuotation->supplier_id;
              DB::table('notification_receivers')->insert(['receiver_id'=>$senderid,'notification_id'=>$notificationId]);
            return ['status'=>'success','message'=>'Successfully rejected tendor'];
        }
        else
            return ['status'=>'failed','message'=>'Failed to reject tendor'];
    }

    public function quotationList(Request $request){
       $quotations = TendorQuotation::select('tendor_quotations.*')
                                    ->join('tendors','tendor_quotations.tendor_id','=','tendors.id')
                                    ->join('users','tendor_quotations.supplier_id','=','users.id')
                                    ->where('tendors.user_id',auth::id())
                                    ->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(users.business_name) like ?', '%'.strtolower($request->search).'%');
                                        }
                                        if($request->status == '0' || $request->status){
                                           $query->where('tendor_quotations.status',$request->status);
                                        }
                                      })
                                    ->orderBy('tendor_quotations.id','desc')->get();
       $data['quotations'] = $quotations;
       return view('vendor.quotation',compact('data'));
    }

    public function quotationPdf($id){
            $quotation = TendorQuotation::select('tendor_quotations.*')->join('tendors','tendor_quotations.tendor_id','=','tendors.id')->where('tendors.user_id',auth::id())->orderBy('tendor_quotations.id','desc')->first();
            $data['quotation'] = $quotation;

        $html   = view('vendor.quotation_pdf',compact('data'));
        //return $html;
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $orderId = date('Ymd') . $data['quotation']->id;
        return $dompdf->stream();
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
