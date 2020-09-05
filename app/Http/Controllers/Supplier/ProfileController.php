<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Department;
use App\Models\Document;
use App\Models\NotificationReceiver;

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
		return view('supplier.profile',compact('data'));
    }

    public function updateProfile(Request $request){
        $input = $request->all();
        $id    = auth::id();
        $rules = array(
            'name'       => 'required|string|max:255',
          //  'title'      => 'required|string|max:255|unique:users,title,'.$id.',id,deleted_at,NULL',
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
        	return ['status'=>'failed','message'=>'Failed to update profile'];
        }
    }

    public function updateDocument(Request $request){
        $input = $request->all();
        $documentFiles = array();       
        foreach ($request->documents as $key => $document) {
            $fileName = str_random('10').'.'.time().'.'.$document->getClientOriginalExtension();
            $document->move(public_path('documents/'), $fileName);
            array_push($documentFiles,['user_id' => auth::id(),'document'=>$fileName , 'title' => $input['titles'][$key]]);
        }
        if($documentFiles){
             \DB::table('user_documents')->insert($documentFiles);
              return ['status'=>'success','message'=>'Successully upload documents'];
        }else{
            return ['status'=>'failed','message'=>'Please upload documents'];
        }
    }

    public function removeDocument($id){
        $document = Document::find($id);
        if($document->delete())
            return ['status'=>'success','message'=>'Successully removed document'];
        else
            return ['status'=>'failed','message'=>'Failed remove document'];
    }

    public function documentList(){
        $documents = \DB::table('user_documents')->select('id','title','document')->where('user_id',auth::id())->get();
        if($documents->toarray()){
            foreach ($documents as $key => $document) {
               $documents[$key]->document = $document->document;
            }
        }
        return view('supplier.document-list',compact('documents'));
    }

    public function addTax(Request $request){
        $input = $request->all();
        $id    = auth::id();
        $rules = array(
            'title'  => 'required',
            'tax'    => 'required',
        );

        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors());
        }
        
        $insertData = array(
          'user_id' => auth::id(),
          'title'   => $input['title'],
          'tax'     => $input['tax']
        );

        $taxId = \DB::table('taxes')->insert($insertData);

        if($taxId){
            return ['status'=>'success','message'=>'Successully added tax'];
        }else{
            return ['status'=>'failed','message'=>'Failed to add tax'];
        }
    }
    
    public function taxList(){
        $taxes = \DB::table('taxes')->select('id','title','tax')->where('user_id',auth::id())->get();
        return view('supplier.tax-list',compact('taxes'));
    }

    public function removeTax(Request $request){
        $input = $request->all();
        $id    = auth::id();
        $rules = array(
            'id'  => 'required',
        );
        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors());
        }
        if(\DB::table('taxes')->where('id',$input['id'])->delete()){
            return ['status'=>'success','message'=>'Successully remove tax'];
        }else{
            return ['status'=>'failed','message'=>'Failed to remove tax'];
        }
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
