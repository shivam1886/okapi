<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Department;
use App\Models\UserCurrency;

class ProfileController extends Controller
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
		$user = User::find(auth::id());
		$departments = Department::where('user_id',auth::id())->get();
		$data = array('user'=>$user,'departments'=>$departments);
		return view('vendor.profile',compact('data'));
    }

    public function updateProfile(Request $request){
        $input = $request->all();
        $id    = auth::id();
        $rules = array(
            'name'       => 'required|string|max:255',
            'title'      => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,'.$id.',id,deleted_at,NULL',
            'phone'      => 'required|unique:users,phone,'.$id.',id,deleted_at,NULL',
            'business_name' => 'required|string|max:255|unique:users,business_name,'.$id.',id,deleted_at,NULL',
            'address'       => 'required|string|max:255',
            'country'       => 'required|string|max:255',
            'state'         => 'required|string|max:255',
            'city'          => 'required|string|max:255',
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
        $User->title     = $input['title'];
        $User->email     = $input['email'];
        $User->phone     = $input['phone'];
        $User->business_name = $input['business_name'];
        $User->address   = $input['address'];
        $User->country   = $input['country'];
        $User->state     = $input['state'];
        $User->city      = $input['city'];
        $User->latitude  = $input['latitude']  ?? 0;
        $User->longitude = $input['longitude'] ?? 0;
        if($fileName){
          $User->profile_image = $fileName;
        }
        if($User->update()){
            if($fileName)
            $this->unlinkImage($preProfileImage);
        	return ['status'=>'success','message'=>'Successully updated profile'];
        }else{
        	return ['status'=>'failedd','message'=>'Failed to update profile'];
        }
    }

    public function createCurrency(Request $request){
        $input = $request->all();
        $rules = array(
            'currency'      => 'required|string|max:3',
        );
        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to add currency', '' , 'errors' => $validator->errors());
        }
        $currency = new UserCurrency;
        $currency->title   = trim($input['currency']);
        $currency->user_id = auth::id();
        if($currency->save())
            return ['status'=>'success','message'=>'Successfully added currency'];
        else
            return ['status'=>'failed','message'=>'failed to add currency'];
    }

    public function currencyList(){
        $data['currency'] = UserCurrency::where('user_id',auth::id())->get();
        return view('vendor.currency-list',compact('data'));
    }

    public function updateCurrency(Request $request,$id){
        $input = $request->all();
        $rules = array(
            'currency'      => 'required|string|max:3',
        );
        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to add currency', '' , 'errors' => $validator->errors());
        }
        $currency = UserCurrency::find($id);
        $currency->title   = trim($input['currency']);
        if($currency->update())
            return ['status'=>'success','message'=>'Successfully updated currency'];
        else
            return ['status'=>'failed','message'=>'failed to update currency'];   
    }

    public function destroyCurrency($id){
        $currency = UserCurrency::find($id);
        if($currency->delete())
           return ['status'=>'success','message'=>'Successfully deleted currency'];
        else
           return ['status'=>'failed','message'=>'failed to delete currency'];   
    }

     public function getImage($image){
        if($image && file_exists('public/images/'.$image)){
          return asset('public/images/'.$image);
        }
           return asset('public/images/user-default-image.png');
    }

     public function getDocument($document){
        if($document && file_exists('public/documents/'.$document)){
          return asset('public/documents/'.$document);
        }
           return asset('public/documents/user-default-image.png');
    }

    public function unlinkImage($image){
        if($image && file_exists('public/images/'.$image)){
              unlink('public/images/'.$image);
        }
    }

    public function unlinkDocument($document){
        if($document && file_exists('public/documents/'.$document)){
              unlink('public/documents/'.$document);
        }
    }
}
