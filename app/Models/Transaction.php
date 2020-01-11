<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = true;
    protected $fillable = array('amount', 'note', 'resturant_id');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }
}
