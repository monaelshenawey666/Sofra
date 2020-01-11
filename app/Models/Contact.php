<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'message', 'state');

    protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        $types = [
            'Complaint' => 'شكوى',
            'Suggestion' => 'اقتراح',
            'Enquiry' => 'استعلام',
        ];

        if (isset($types[$this->state])) {
            return $types[$this->state];
        }
        return "";
    }

}
