<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
//////////////authenticable//////////////

class Resturant extends Authenticatable
{

    protected $table = 'resturants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'image','region_id', 'minimum_charger','whatsNum',
        'delivery_phone','pin_code','api_token','time_of_preparation','opening_time','closed_time','rate');
    protected  $appends=['is-open'];
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Review');
    }


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'accountable');
    }
    public function notifications()
    {
        return $this->morphMany('App\Models\Notification','notifiable');
    }
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }



    protected $hidden = [
        'password', 'api_token',
    ];

    public function getIsOpenAttribute()
    {
        return Carbon::now()->between(
            Carbon::parse($this->opening_time),
            Carbon::parse($this->closed_time)
        );
    }

    public function getTotalOrdersAmountAttribute($value)
    {
         $total_order_amount= $this->orders()->where('state',  'delivered')->sum('total');

        return $total_order_amount;
    }

    public function getTotalCommissionsAttribute($value)
    {
        $commissions = $this->orders()->where('state', 'delivered')->sum('commission');

        return $commissions;
    }

    public function getTotalPaymentsAttribute($value)
    {
        $payments = $this->transactions()->sum('amount');

        return $payments;
    }

    public function getResturantDetailsAttribute()
    {
       // $cityName = count($this->city) ? $this->city->name.':' : '';
        $cityName =  $this->region->name.':'  ;
        return $cityName.' : '.$this->region->city->name.' : '.$this->phone;
    }


    }
