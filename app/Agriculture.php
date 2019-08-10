<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agriculture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commodity_id', 'agriculture_name', 'thumbnail',
    ];

    /**
     * The Relations 
     */
    public function commodity()
    {
    	return $this->belongsTo('App\Commodity');
    }
}
