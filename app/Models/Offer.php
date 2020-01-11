<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('image', 'name', 'description', 'start_date', 'end_date', 'resturant_id');
    protected $appends = ['available'];
    protected $dates = ['start_date','end_date'];
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];


    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }
    public function getAvailableAttribute($value)
    {
        $today = Carbon::now()->startOfDay();
        dd($today);
        if ($this->start_date->startOfDay() <= $today && $this->end_date->endOfDay() >= $today)
        {
            return true;
        }
        return false;
    }

}
