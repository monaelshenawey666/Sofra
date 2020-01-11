<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('facebook','twitter','instagram','commission','commissions_text','terms','about_app','account_bank');

}
