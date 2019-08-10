<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualityOfAgriculture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agriculture_id', 'quality_id', 
    ];

    /**
     * The Relations 
     */
	public function agriculture()
	{
		return $this->belongsTo('App\Agriculture');
	}

	public function quality()
	{
		return $this->belongsTo('App\Quality');
	}
}
