<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable; 
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'name', 'email', 'password',
     ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'password', 'remember_token',
     ];

     public function getProfileImageAttribute($value){
          return asset('public/images/'.$value);
     }

     public function documents(){
        return $this->hasMany('App\Models\Document','user_id','id');
     }

     public function departments(){
        return $this->hasMany('App\Models\Department','user_id','id');
     }

     public function currency(){
        return $this->hasMany('App\Models\UserCurrency','user_id','id');
     }

     public function notifications(){
        return $this->hasMany('App\Models\NotificationReceiver','receiver_id','id');
     }
}
