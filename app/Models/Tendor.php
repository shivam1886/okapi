<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tendor extends Model
{
     protected $table = 'tendors';

     use SoftDeletes;

	 function user(){
	    	return $this->hasOne('App\User','id','user_id');
	 }

     function products(){
    	return $this->hasMany('App\Models\TendorProduct','tendor_id','id');
     }

     function suppliers(){
    	return $this->hasMany('App\Models\TendorSupplier','tendor_id','id');
     }
}
