<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TendorSupplier extends Model
{
    protected $table = 'tendor_suppliers';

      public function user(){
    	return  $this->hasOne('App\User','id','supplier_id');
     }

     public function tendor(){
     	return $this->hasOne('App\Models\Tendor','id','tendor_id');
     }
}
