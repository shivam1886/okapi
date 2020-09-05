<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Document;
use auth;

class HomeController extends Controller
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

    public function profile(Request $request){
      $data['user'] = User::find(auth::id());
      return view('admin.profile',compact('data'));
    }

    public function profileUpdate(Request $request){
        $input = $request->all();
        $id    = auth::id();
        $rules = array(
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,'.$id.',id,deleted_at,NULL',
            'phone'      => 'unique:users,phone,'.$id.',id,deleted_at,NULL',
        );

        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors());
        }

        $fileName = null;
        if ($request->hasFile('profile_image')) {
            $fileName = str_random('10').'.'.time().'.'.request()->profile_image->getClientOriginalExtension();
            request()->profile_image->move(public_path('images/'), $fileName);
        }
        
        $User = User::find($id);
        $preProfileImage = $User->profile_image;
        $User->name      = $input['name'];
        $User->email     = $input['email'];
        $User->phone     = $input['phone']   ?? '';
        $User->address   = $input['address'] ?? '';
        $User->country   = $input['country'] ?? '';
        $User->state     = $input['state']   ?? '';
        $User->city      = $input['city']    ?? '';
        $User->latitude  = $input['latitude']  ?? 0;
        $User->longitude = $input['longitude'] ?? 0;
        if($fileName){
          $User->profile_image = $fileName;
        }
        if($User->update()){
          //  if($fileName)
          //  $this->unlinkImage($preProfileImage);
        	return ['status'=>'success','message'=>'Successully updated profile'];
        }else{
        	return ['status'=>'failed','message'=>'Failed to update profile'];
        }
    }

    public function vendors(Request $request){
       $data['vendors'] = User::where('user_type','2')->orderBy('id','desc')->get();
       return view('admin.vendor',compact('data'));
    }

    public function vendorDetails($id){
        $data['vendor'] = User::find($id);
        return view('admin.vendor-details',compact('data'));        
    }

    public function suppliers(Request $request){
        $data['suppliers'] = User::where('user_type','3')->orderBy('id','desc')->get();
        return view('admin.supplier',compact('data'));    
    }

    public function supplierDetails($id){
        $data['supplier'] = User::find($id);
		return view('admin.supplier-details',compact('data'));    
    }

    public function vendorStatus(Request $request){
        $input = $request->all();
        $user = User::find($input['id']);
        $user->status = $input['status'];
        if($input['status'] == '1')
             $text = 'active';
        else
             $text = 'dective';
        if($user->update())
             return ['status'=>'success','message'=>'Successully ' . $text .' vendor'];
         else
             return ['status'=>'failed','message'=>'Failed to ' . $text .' vendor'];
    }

    public function supplierStatus(Request $request){
        $input = $request->all();
        $user = User::find($input['id']);
        $user->status = $input['status'];
        if($input['status'] == '1')
             $text = 'active';
        else
             $text = 'dective';
        if($user->update())
             return ['status'=>'success','message'=>'Successully ' . $text .' supplier'];
         else
             return ['status'=>'failed','message'=>'Failed to ' . $text .' supplier'];
    }

    public function approveDocument(Request $request){
        $input = $request->all();
        $document = Document::find($input['id']);
        $document->is_varified = $input['status'];
        if($input['status'] == '1')
          $text = 'verify';
        else
          $text = 'reject';

        if($document->update())
            return ['status'=>'success','message'=>'Successully '. $text . ' document' ];
        else
            return ['status'=>'failed','message'=>'Failed '. $text . ' document' ];
    }

    public function approveSupplier(Request $request){
        $input = $request->all();
        $user = User::find($input['id']);
        $user->is_verified = $input['status'];
        if($input['status'] == '1')
             $text = 'verify';
        else
             $text = 'reject';
        if($user->update())
             return ['status'=>'success','message'=>'Successully ' . $text .' supplier'];
         else
             return ['status'=>'failed','message'=>'Failed to ' . $text .' supplier'];
    }

}
