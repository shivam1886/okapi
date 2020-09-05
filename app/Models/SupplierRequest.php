<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierRequest extends Model
{
    protected $table = 'supplier_requests';

    public function user(){
    	return $this->hasOne('App\User','id','supplier_id');
    }
}
