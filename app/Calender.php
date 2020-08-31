<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
	 protected $fillable = [
        'date',
    ];

    public function day_status()
    {
        return $this->belongsTo('App\DayStatus','day_status_id','id');
    }

    public function attend_leave()
    {
        return $this->hasMany('App\AttendLeave');
    }

}
