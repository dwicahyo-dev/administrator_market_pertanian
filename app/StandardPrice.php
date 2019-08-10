<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandardPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agriculture_id', 'user_id', 'highest_price', 'lowest_price'
    ];

    /**
     * The Relations 
     */
    public function agriculture()
    {
    	return $this->belongsTo('App\Agriculture');
    }
}
