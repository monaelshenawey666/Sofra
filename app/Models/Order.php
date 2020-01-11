<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('cost', 'client_id', 'address_delivery', 'resturant_id', 'state', 'commission', 'net', 'delivery_fee', 'payment_method_id','total');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    public function payment_method()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price','quantity','note');
    }

}
