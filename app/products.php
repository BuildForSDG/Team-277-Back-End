<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = [
        'name','description','quantity','price','isAvailable','image','farm_id',
        'measurement_id',
        'category_id'
    ];
    

    /*
    * Get  farm 
    */
    public function farm()
    {
        return $this->belongsTo('App\farms', 'id');
    }
    
    /**
     *  get the Category tha  belong to the farms
     */
    public function category()
    {
        return $this->belongsTo('App\category', 'id');
    }

    /**
     *  get the Category tha  belong to the farms
     */
    public function measurement()
    {
        return $this->belongsTo('App\measurement_unit', 'id');
    }
}
