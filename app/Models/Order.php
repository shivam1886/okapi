<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
     use SoftDeletes;
     
     public function items(){
      return $this->hasMany('App\Models\OrderItem','order_id','id');
     }

     public function supplier(){
      return $this->hasOne('App\User','id','supplier_id');
     }
 
     public function vendor(){
      return $this->hasOne('App\User','id','vendor_id');
     }

     public function tendor(){
      return $this->hasOne('App\Models\Tendor','id','tendor_id');
     }

}
