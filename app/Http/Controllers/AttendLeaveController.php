<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AttendLeave;
use App\Weekends;
use App\AttendLeaveSetting;
use Carbon\Carbon;
use App\Calender;
use App\UserStatus;
use Cache;
use Illuminate\Support\Facades\Validator;
use App\DayStatus;
use App;
use App\User;
use App\About;

class AttendLeaveController extends Controller
{
	public function day(Request $request , $date ,$paginate)
    {
    	
        if ($paginate <= 0) 
    	{
    		$paginate = Cache::get('attend_today_paginate', function() { return 10; });
    	}
    	else
    	{
    		Cache::forever('attend_today_paginate', $paginate);
    	}

        $current_date = $date;
        $date = Calender::where('date',$current_date)->has('attend_leave')->first();
        if(!isset($date))
        {
            //dd("this day maybe vactation,or before the system work or not come"); 
            return view('no_attend'); 
        }

        $attend_leaves = AttendLeave::where('calender_id',$date->id)->paginate($paginate);
        $user_statuses = UserStatus::all();
        $home =  About::first();
        return view('table_attend_today',compact('date','attend_leaves','user_statuses','home'));
    }

    

    protected function validator(array $data)
    {
       return Validator::make($data, [
            'slct_attend' => ['required', 'exists:App\UserStatus,id'],
            'slct_leave' => ['required','exists:App\UserStatus,id'],
        ]);

    }

    public function update_attend_leave(Request $request, $id)
    {
        $this->validator($request->all())->validate();

        $attend_leave = AttendLeave::find($id);
        $attend_leave->attend_user_status_id=$request->get('slct_attend');
        $attend_leave->attend_time =  Carbon::now()->toTimeString();
        $attend_leave->attend_by_admin = Carbon::now()->toTimeString();

        $attend_leave->leave_user_status_id=$request->get('slct_leave');
        $attend_leave->leave_time =  Carbon::now()->toTimeString();
        $attend_leave->leave_by_admin = Carbon::now()->toTimeString();

        $attend_leave->save();
        return response()->json(['success'=>'updated']);
        

    }

    public function year_month_statistics( $year, Request $request)
    {
        
        $years = Calender::has('attend_leave')->pluck('date') ->countBy(function($val) 
            {
                return Carbon::parse($val)->format('Y') ;
            }) ;

        $months = Calender::has('attend_leave')->whereYear('date',$year)->pluck('date') ->countBy(function($val) 
            {
                //Carbon::setLocale('es');
                // $car = new Carbon($val);
                // return (string) ($car->locale('ar')->monthName) ;
                return Carbon::parse($val)->monthName ;
            }) ;

        // $dates = Calender::has('attend_leave')->pluck('date') ->mapWithKeys(function($val) 
        //     {
        //         return [Carbon::parse($val)->format('Y') => Carbon::parse($val)->format('M')] ;
        //     }) ;

        //dd($years,$months);

        $home =  About::first();
        return view('year_month_statistics',compact('year','years','months','home'));
        

    }


    public function statictics(Request $request , $year , $month , $worker_paginate , $table_paginate)
    {
        if ($worker_paginate <= 0) 
        {
            $worker_paginate = Cache::get('worker_paginate', function() { return 5; });
        }
        else
        {
            Cache::forever('worker_paginate', $worker_paginate);
        }
        if ($table_paginate <= 0) 
        {
            $table_paginate = Cache::get('table_paginate', function() { return 5; });
        }
        else
        {
            Cache::forever('table_paginate', $table_paginate);
        }

        $attend_leaves = AttendLeave::whereHas('calendar', function($q) use($year,$month)
            {
                $q->whereYear('date','=',$year)->whereMonth('date','=',$month);
            })->orderBy('user_id')->get();
        
        $workers = $attend_leaves->groupBy('user_id');
        $workers = $workers->paginate($worker_paginate);
        $statistics_of_users =collect();
        foreach ($workers as $key => $worker) 
        {
            if(App::isLocale('ar')){$name = $worker->first()->user->name_ar;}
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
                $q->whereYear('date',$year)->whereMonth('date',$month);
            })->where('user_id',$worker->first()->user_id)->paginate($table_paginate,['*'],'table');
            
            //dd($other_leave);
            
            $statistics_of_users[$key] = (["name" => $name , "attend_leave_counter" => $attend_leave_counter ,"absence_counter" => $absence_counter , "other_attend" => $other_attend ,"other_leave" => $other_leave,"ordinary"=>$ordinary]);
        
        }

        //dd($attend_leaves,$statistics_of_users,$workers );
        $home =  About::first();
        return view('statistics',compact('statistics_of_users','workers','year','month','worker_paginate','table_paginate','home'));

    }

    


}
