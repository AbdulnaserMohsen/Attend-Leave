<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    public function attendLeave_attend()
   {
   		return $this->hasMany('App\AttendLeave', 'attend_user_status_id');
   }

   public function attendLeave_leave()
   {
   		return $this->hasMany('App\AttendLeave', 'leave_user_status_id');
   }
}
