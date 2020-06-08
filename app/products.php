<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = [
        'name','description','quantity','price','isAvailable','image','farm_id',
        'measurement_units_id',
        'category_id'
    ];
    

    /*
    * Get  farm 
    */
    public function farms()
    {
        return $this->belongsTo('App\farms', 'farm_id', 'id');
    }
    
    /**
     *  get the Category that  belong to the farms
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
