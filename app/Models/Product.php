<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('image', 'name', 'description', 'price' ,'category_id','resturant_id');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
