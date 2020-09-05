<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Auth;

class ProductController extends Controller
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
        $Products = Product::where('user_id',auth::id())->orderBy('id','desc')->where(function($query) use ($request){
                                        if($request->search){
                                        $query->whereRaw('LOWER(products.title) like ?', '%'.strtolower($request->search).'%');
                                        }
                                      })->get(); 
        $data['products'] = $Products;
        if($request->ajax()){
            return view('supplier.product-list',compact('data'));
        }
        return view('supplier.product',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
         $rules = array(
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required',
         );
         // Validate 
         $validator = \Validator::make($request->all(), $rules);
         if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to add product', '' , 'errors' => $validator->errors());
         }
         $Product = new Product;
         $Product->title       = $input['title'];
         $Product->description = $input['description'];
         $Product->price       = $input['price'];
         $Product->currency    = $input['currency'] ?? 'USD';
         $Product->user_id     = auth::id();
         if($Product->save()){
            return ['status'=>'success','message'=>'Successully added product'];
         }else{
            return ['status'=>'failed','message'=>'Failed to add product'];
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
            $id = $request->id;
            $product = Product::find($id);
            if($product){
               $product->url = route('supplier.product.destroy',$id);
              return ['status'=>true,'message'=>'Record found','data'=>$product];
            }
            else{
              return ['status'=>false , 'message'=>'Record not found'];
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required',
        );
        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update product', '' , 'errors' => $validator->errors());
        }
        $Product = Product::find($input['id']);
        $Product->title       = $input['title'];
        $Product->description = $input['description'];
        $Product->currency    = $input['currency'] ?? 'USD';
        $Product->price       = $input['price'];
        if($Product->update()){
            return ['status'=>'success','message'=>'Successully updated product'];
        }else{
            return ['status'=>'failed','message'=>'Failed to update product'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product->delete())
            return ['status'=>'success','message'=>'Successully removed product'];
        else
            return ['status'=>'failed','message'=>'Failed to remove product'];
    }
}
