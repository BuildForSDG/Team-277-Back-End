<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
     //
     protected $fillable = [
        'street1', 'street2','suburb','city_id','country_id','post_code', 
    ];

    public function farms()
    {
        return $this->belongsTo('App\farms', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\country', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\city', 'id');
    }

}
