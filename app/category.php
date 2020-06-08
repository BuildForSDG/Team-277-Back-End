<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function products(){
        return $this->hasMany(products::class);
    }

    
}
