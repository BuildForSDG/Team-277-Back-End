<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_reviews extends Model
{
    //
    public function product(){
        return $this->belongsTo(products::class);
    }
}
