<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $table = 'user_documents';

       use SoftDeletes;

      public function getDocumentAttribute($value){
		return asset('public/documents/'.$value);
     }
}
