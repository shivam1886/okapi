<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Department;

class DepartmentController extends Controller
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

    public function departmentsList(){
        $departments = Department::where('user_id',auth::id())->get();
        $data = array('departments'=>$departments);
        return view('departments',compact('data'));
    }

    public function departmentCreate(Request $request){
        $input = $request->all();
        $user_id  = auth::id();
        $rules = array(
            'department_name'     => 'required|string|max:255',
            'department_email'    => 'required|string|email',
            'department_phone'    => 'required',
        );

        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors());
        }
        
        $Department = new Department;
        $Department->user_id   = $user_id;
        $Department->name      = $input['department_name'];
        $Department->email     = $input['department_email'];
        $Department->phone     = $input['department_phone'];
        if($Department->save()){
            return ['status'=>'success','message'=>'Successully added department'];
        }else{
            return ['status'=>'failed','message'=>'Failed to delete department'];
        }
    }

    public function departmentUpdate(Request $request){
        $input = $request->all();
        $rules = array(
            'department_id'       => 'required',
            'department_name'     => 'required|string|max:255',
            'department_email'    => 'required|string|email',
            'department_phone'    => 'required',
        );

        // Validate 
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return array('status' => 'error' , 'msg' => 'failed to update apartment', '' , 'errors' => $validator->errors());
        }
        
        $Department = Department::find($input['department_id']);
        $Department->name      = $input['department_name'];
        $Department->email     = $input['department_email'];
        $Department->phone     = $input['department_phone'];
        if($Department->update()){
            return ['status'=>'success','message'=>'Successully updated department'];
        }else{
            return ['status'=>'failed','message'=>'Failed to update department'];
        }
    }

    public function departmentDelete(Request $request){
    	$input = $request->all();
    	if(Department::where('user_id',auth::id())->where('id',$input['id'])->delete())
    	return ['status'=>'success','message'=>'Successfully deleted department'];
        else
    	return ['status'=>'failed','message'=>'Failed to delete department'];
    }
}
