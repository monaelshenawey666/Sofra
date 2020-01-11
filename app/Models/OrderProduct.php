<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model 
{

    protected $table = 'order_product';
    public $timestamps = true;
    protected $fillable = array('special_order', 'quantity', 'total_cost', 'product_id', 'order_id', 'resturant_id');

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

}