<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationReceiver extends Model
{
     use SoftDeletes;

     protected $table = 'notification_receivers';
     
     public function receiver(){
      return $this->hasOne('App\User','id','receiver_id');
     }

     public function notification(){
     	return $this->hasOne('App\Models\Notification','id','notification_id');
     }

}
