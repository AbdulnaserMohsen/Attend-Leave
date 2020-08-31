<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayStatus extends Model
{
    public function calender()
    {
        return $this->hasMany('App\Calender');
    }
}
