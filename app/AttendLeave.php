<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendLeave extends Model
{
   public function calendar()
   {
   		return $this->belongsTo('App\Calender','calender_id','id');
   }

   public function status_attend()
   {
   		return $this->belongsTo('App\UserStatus','attend_user_status_id','id');
   }

   public function status_leave()
   {
   		return $this->belongsTo('App\UserStatus','leave_user_status_id','id');
   }

   public function user()
   {
         return $this->belongsTo('App\User','user_id','id');
   }

}
