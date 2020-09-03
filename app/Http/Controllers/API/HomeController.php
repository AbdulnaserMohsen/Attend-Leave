<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\AttendLeave;
use App\Calender;
use Carbon\Carbon;
use Cache;
use App\UserStatus;
use App\Weekends;
use App\AttendLeaveSetting;
use App\User;


class HomeController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth:api');
    
	}

    protected function init($current_date)
    {
        $dayname = Carbon::now()->locale('en')->isoFormat('dddd'); //get day name
        $newday = new Calender();
        $newday->date = $current_date;
        $weekends = Weekends::pluck('day_en')->toArray();
        //dd($weekends , $dayname);
        if(in_array($dayname,$weekends))//if weekend
        {
            $newday->day_status_id = 2; 
        }
        else if($newday)
        {
            $newday->day_status_id = 1;
        }
        $newday->save();

    }
    protected function all_absence($newday , $attend_leave_setting)
    {
        
        $users = User::whereNotIn('id',[1,2,3])->pluck('id')->toArray(); //all users
        $exists_users = AttendLeave::where('calender_id', $newday->id)->whereIn('user_id', $users)->pluck('user_id')->toArray(); // users in attend leave table
        if(count($exists_users) == count($users))  // to prevent iterate
        {
            return;
        }

        $not_exists_ueser = array_diff($users, $exists_users);
        $absence_all =[];
        foreach ($not_exists_ueser as $key => $value) 
        {
            $absence_all[$key] = array( 'user_id'=>$value , 'calender_id'=>$newday->id , 'setting_id'=>$attend_leave_setting->id , 'attend_user_status_id'=>3 , 'leave_user_status_id'=>3 , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') );
        }
        AttendLeave::insert($absence_all); //make not exists users absence

    }
    /**
     * Get function 
     *
     * Post the authenticated User
     * if the current date not exists in calendar add it through init
     * if the day not work day 
     	* @return [json] message=> no attend, $newday object
     * 
     *
     * @return [json] user_statuses, attend_timer, leave_timer, attend_leave_setting, 
     * 				  user_attend_leave,
     */
    public function home(Request $request)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $newday =  Calender::where('date',$current_date)->first();
        if($newday == null)
        {
            $this->init($current_date);
            $newday =  Calender::where('date',$current_date)->first();
        }
        
        if($newday->day_status_id != 1)
        {
            //return view("no_attend",compact("newday")); 
            return response()->json(['message'=>'no attend','newday' => $newday,]);
        }
        else
        {
            //dd("attend");
            $user_statuses = UserStatus::whereIn('id',[1,2])->get(); // to be sent 
            $attend_leave_setting =AttendLeaveSetting::latest()->first();//get last record
            $this->all_absence($newday , $attend_leave_setting);

            if(Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->attend_time_from), false)>0)
            {
                $attend_timer = 0;// the time to save attend not start
            }
            else
            {
               $attend_timer = Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->attend_time_to), false); // the rest of seconds to attend to be finished
               
               if($attend_timer<0) {$attend_timer=-1;}//the time to save attend finished 
            }

            if(Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->leave_time_from), false)>0)
            {
                $leave_timer = 0;// the time to save leave not start
            }
            else
            {
               $leave_timer = Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->leave_time_to), false);// the rest of seconds to leave to be finished
               
                if($leave_timer<0) {$leave_timer=-1;}//the time to save leave finished 
            }
            
            if(in_array($request->user()->id, [1,2,3])){$user_id = 4;}
        	else{$user_id = $request->user()->id;}
            
            $user_attend_leave = AttendLeave::where('calender_id',$newday->id)->where('user_id',$user_id)->first();

            return response()->json([
	            'user_statuses' => $user_statuses,
	            'attend_timer' => $attend_timer,
	            'leave_timer' => $leave_timer,
	            'attend_leave_setting' => $attend_leave_setting,
	            'user_attend_leave' => $user_attend_leave,
	        ]);

        } 
        

    }
    /**
     * Post function 
     *
     * Post the authenticated User
     * 
     *
     * @return [json] user_statuses, attend_timer, leave_timer, attend_leave_setting, 
     * 				  user_attend_leave,
     */
    public function user_attend(Request $request)
    {
    	if(in_array($request->user()->id, [1,2,3])){$user_id = 4;}
        else{$user_id = $request->user()->id;}

        $current_date = Carbon::now()->format('Y-m-d');
        $current_day =  Calender::where('date',$current_date)->first();
        $attend_leave_setting =AttendLeaveSetting::latest()->first();

        if( ($current_day->day_status_id == 1) && ( (Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->attend_time_from), false)<0) && (Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->attend_time_to), false)>0 ) ||  $attend_leave_setting->enable_after_attend ) )
        {
            //dd("aaaaae");
            $attend = AttendLeave::where('calender_id',$current_day->id)->where('user_id', $user_id)->first();
            $attend->setting_id = AttendLeaveSetting::latest()->first()->id;
            $attend->attend_user_status_id = 1;
            $attend->attend_time =  Carbon::now()->toTimeString();
            $attend->attend_by_user = Carbon::now()->toTimeString();

            if( Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->attend_time_to), false)<0 &&  $attend_leave_setting->enable_after_attend != 0)
            {
                $attend->attend_hint = Carbon::now()->diff(Carbon::parse($attend_leave_setting->attend_time_to))->format('%H:%i');
            }
            
            $attend->save();
            return response()->json(['message'=>'Attended Successfully']);
        }
        else
        {
        	return response()->json(['message'=>'Time to attend finished']);
        }

    }

    public function user_leave(Request $request)
    {
    	if(in_array($request->user()->id, [1,2,3])){$user_id = 4;}
        else{$user_id = $request->user()->id;}

        $current_date = Carbon::now()->format('Y-m-d');
        $current_day =  Calender::where('date',$current_date)->first();
        $attend_leave_setting =AttendLeaveSetting::latest()->first();

        if( ($current_day->day_status_id == 1) && ( (Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->leave_time_from), false)<0) && (Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->leave_time_to), false)>0 ) ||  $attend_leave_setting->enable_before_leave ) )
        {
            //dd("aaaaae");
            $attend = AttendLeave::where('calender_id',$current_day->id)->where('user_id', $user_id)->first();
            $attend->setting_id = AttendLeaveSetting::latest()->first()->id;
            $attend->leave_user_status_id = 2;
            $attend->leave_time =  Carbon::now()->toTimeString();
            $attend->leave_by_user = Carbon::now()->toTimeString();

            if( Carbon::now()->diffInSeconds(Carbon::parse($attend_leave_setting->leave_time_from), false)>0 &&  $attend_leave_setting->enable_before_leave )
            {
                $attend->leave_hint = Carbon::now()->diff(Carbon::parse($attend_leave_setting->leave_time_from))->format('%H:%i');
            }
            
            $attend->save();
            return response()->json(['message'=>'Leaved Successfully']);
        }
        else
        {
        	return response()->json(['message'=>'Time to leave finished']);
        }
        //dd("ddddeeeeee");
    }

    /**
     * Post the authenticated User
     * @param  [string] language
     * @param  [string] year
     * @return [json] year , years , months
     */
    public function user_year_months_statistics(Request $request)
    {
    	if(in_array($request->user()->id, [1,2,3])){$user_id = 4;}
        else{$user_id = $request->user()->id;}
        $input = $request->all();
        $language = $input['language'];

        $years = Calender::whereHas('attend_leave', function($q) use($user_id)
                    {
                        $q->where('user_id', $user_id);
                    })->pluck('date')->countBy(function($val) 
                    {
                        return Carbon::parse($val)->format('Y') ;
                    }) ;

        $months = Calender::whereHas('attend_leave', function($q) use($user_id)
                        {
                            $q->where('user_id', $user_id);
                        })->whereYear('date',$input['year'])->pluck('date') ->countBy(function($val) use($language)
                        {
                            return Carbon::parse($val)->locale($language)->monthName ;
                        });


        return response()->json([
            'year' => $input['year'],
            'years' => $years,
            'months' => $months,
        ]);

    }

    /**
     * Post the authenticated User
     * @param  [string] language
     * @param  [string] year
     * @param  [string] month
     * @param  [string] table_paginate
     * @return [json] user_statictics object , year, month ,table_paginate 
     */
    public function user_statictics(Request $request )
    {
    	$input = $request->all();

    	$language = $input['language'];
    	$year = $input['year'];
    	$month = $input['month'];
    	$table_paginate = $input['table_paginate'];
    	$user_id = $request->user()->id;
    	if(in_array($user_id, [1,2,3])){$user_id = 4;}
        else{$user_id = $request->user()->id;}

        
        if ($table_paginate <= 0) 
        {
            $table_paginate = Cache::get('table_paginate', function() { return 5; });
        }
        else
        {
            Cache::forever('table_paginate', $table_paginate);
        }

        $attend_leaves = AttendLeave::where('user_id',$user_id)->whereHas('calendar', function($q) use($year,$month)
            {
                $q->whereYear('date',$year)->whereMonth('date',$month);
            })->orderBy('user_id')->get();
        
        $workers = $attend_leaves->groupBy('user_id');
        //$workers = $workers->paginate($worker_paginate);
        $statistics_of_users =collect();
        foreach ($workers as $key => $worker) 
        {
        	if($language == "ar"){$name = $worker->first()->user->name_ar;}
            else {$name = $worker->first()->user->name_en;}
            
            $absence_counter = $worker->filter( function($worker) 
                {
                    return strstr($worker->attend_user_status_id, "3") ||
                           strstr($worker->leave_user_status_id, "3");
                })->count();

            $attend_leave_counter = $worker->where("attend_user_status_id",1)->where("leave_user_status_id",2)->count();

            $other_attend = $worker->whereNotIn("attend_user_status_id",[1,3])->whereNotIn("leave_user_status_id",[3])->countBy("attend_user_status_id")->keyBy(function ($item, $key)
                {
                    if(App::isLocale('ar')){$key = UserStatus::where('id',$key)->first()->name_ar;}
                    else {$key = UserStatus::where('id',$key)->first()->name_en;}
                    return $key;
                }); 

            $other_leave = $worker->whereNotIn("leave_user_status_id",[2,3])->whereNotIn("attend_user_status_id",[3])->countBy('leave_user_status_id')->keyBy(function ($item, $key)
                {
                    if(App::isLocale('ar')){$key = UserStatus::where('id',$key)->first()->name_ar;}
                    else {$key = UserStatus::where('id',$key)->first()->name_en;}
                    return $key;
                }); 

            $ordinary = AttendLeave::whereHas('calendar', function($q) use($year,$month)
            {
                $q->whereYear('date', $year)->whereMonth('date',$month);
            })->where('user_id',$worker->first()->user_id)->paginate($table_paginate,['*'],'table');
            
            //dd($other_leave);
            
            $statistics_of_users[$key] = (["name" => $name , "attend_leave_counter" => $attend_leave_counter ,"absence_counter" => $absence_counter , "other_attend" => $other_attend ,"other_leave" => $other_leave,"ordinary"=>$ordinary]);
        
        }
        
        return response()->json([
            'statistics_of_users' => $statistics_of_users,
            'year' => $year,
            'month' => $month,
            'table_paginate' => $table_paginate,
        ]);

    }



}
