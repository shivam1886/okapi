<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorSupplier extends Model
{
    protected $table = 'vendor_suppliers';

      public function user(){
    	return  $this->hasOne('App\User','id','supplier_id');
     }
}
