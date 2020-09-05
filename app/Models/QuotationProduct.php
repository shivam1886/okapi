<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model
{
    protected $table = 'tendor_quotation_products';

     public function product(){
    	return $this->hasOne('App\Models\TendorProduct','id','product_id');
     }

     public function user(){
    	return $this->hasOne('App\User','id','supplier_id');
     }

     public function tendor(){
    	return $this->hasOne('App\Models\Tendor','id','tendor_id');
     }
}
