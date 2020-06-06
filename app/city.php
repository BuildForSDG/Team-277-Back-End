<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    /*
    * Get  farm 
    */
    public function farm()
    {
        return $this->belongsTo('App\country', 'id');
    }
}
