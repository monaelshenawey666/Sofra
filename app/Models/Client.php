<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'region_id','profile_image','pin_code', 'api_token');

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'accountable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notifiable');
    }


protected $hidden = [
'password','api_token'
];
}
