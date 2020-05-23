<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class farms extends Model
{
    protected $fillable = [
        'name','description','size','user_id','address_id','category_id',
        'measurement_id',
        'gio_location','monthly_income'
    ];
    //

    /*
    * Get  user who own the farm
    */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
    /**
     * Get adddress that belong to the farm
     */
    public function address()
    {
        return $this->hasMany('App\address', 'id');
    }
    /**
     *  get the Category tha  belong to the farms
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'id');
    }
}