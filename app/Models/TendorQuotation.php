<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TendorQuotation extends Model
{
    protected $table = 'tendor_quotations';

     function user(){
        return $this->hasOne('App\User','id','supplier_id');
     }

     function tendor(){
    	return $this->hasOne('App\Models\Tendor','id','tendor_id');
     }

     function quotationProduct(){
    	return $this->hasMany('App\Models\QuotationProduct','tendor_id','tendor_id');
     }

     function tax(){
     	return $this->hasOne('App\Models\Tax','id','tax_id');
     }

}
