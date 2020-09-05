<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\AttendLeaveSetting;
use App\AttendLeave;
use App\DayStatus;
use App\Calender;
use App\UserStatus;
use Cache;
use Illuminate\Support\Facades\Validator;
use App\About;

class SettingController extends Controller
{
    public function attend_leave()
    {
       	$today = Carbon::now()->format('Y-m-d');
       $date = Calender::where('date',$today)->first();
       $today_count = AttendLeave::where('calender_id',$date->id)->Where(function($query) {
                $query->where('attend_user_status_id',"!=",5)
                      ->orwhere('leave_user_status_id',"!=",5);
            })->count();
       
       	$attend_leave_history_count = AttendLeave::groupBy('calender_id')->get()->count();

       	$setting_count = AttendLeaveSetting::count();
       	$day_status_count = DayStatus::count();
       	$calender_count = Carbon::now()->diffInDays(Carbon::now()->copy()->endOfYear());
       	$user_status_count = UserStatus::count();


        $home =  About::first();
        return view('attend_leave',compact('today_count','attend_leave_history_count','setting_count','day_status_count','calender_count','user_status_count','home'));
    }

    public function settings($paginate)
    {
    	if ($paginate <= 0) 
    	{
    		$paginate = Cache::get('setting_paginate', function() { return 10; });
    	}
    	else
    	{
    		Cache::forever('setting_paginate', $paginate);
    	}
        
        $settings=AttendLeaveSetting::paginate($paginate);
       
        $home =  About::first();
       	return view('table_setting',compact('settings','home'));
    }
    

    protected function validator(array $data)
    {
       return Validator::make($data, [
            'attend_from' => ['required', 'date_format:H:i'],
            'attend_to' => ['required', 'date_format:H:i', 'after:attend_from'],
            'leave_from' => ['required', 'date_format:H:i'],
            'leave_to' => ['required', 'date_format:H:i', 'after:leave_from'],
        ]);

    }
    public function add_setting(Request $request)
    {
    	$this->validator($request->all())->validate();
    	
        $setting= new AttendLeaveSetting();
        //dd($request->get('enable_attend'));
        if($request->get('enable_attend')){$setting->enable_after_attend=1;}  
        $setting->attend_time_from=$request->get('attend_from');
        $setting->attend_time_to=$request->get('attend_to');
        
        if($request->get('enable_leave')){$setting->enable_before_leave=1;}
        $setting->leave_time_from=$request->get('leave_from');        
        $setting->leave_time_to=$request->get('leave_to');

        $setting->save();
        return response()->json(['success'=>'added']);
    }

        public function delete_setting($id)
    {
    	if($id == 1 )
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		$setting = AttendLeaveSetting::find($id);
            $setting->delete();
            return response()->json(['success'=>'deleted']);
    	}
        
    }

    public function delete_all_settings($ids)
    {
    	$ids = explode(',', $ids);
    	if(in_array(1,$ids) )
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		AttendLeaveSetting::whereIn('id',$ids)->delete();
            return response()->json(['success'=>"deleted all"]);
    	}

    }

    public function disable_attend(Request $request, $id)
    {
    	if($id == 1 )
    	{
            return response()->json(['failed'=>'not authorized to disable or enable']);
    	}
    	else
    	{
    		$user= AttendLeaveSetting::find($id);
    		$user->enable_after_attend=0;
            $user->save();
            return response()->json(['success'=> __('admin.not_allowed')]);
    	}
        
    }

    public function enable_attend(Request $request, $id)
    {
    	if($id == 1 )
    	{
            return response()->json(['failed'=>'not authorized to disable or enable']);
    	}
    	else
    	{
    		$user= AttendLeaveSetting::find($id);
    		$user->enable_after_attend=1;
            $user->save();
            return response()->json(['success'=> __('admin.allowed')]);
    	}
        
    }

    public function disable_leave(Request $request, $id)
    {
    	if($id == 1 )
    	{
            return response()->json(['failed'=>'not authorized to disable or enable']);
    	}
    	else
    	{
    		$user= AttendLeaveSetting::find($id);
    		$user->enable_before_leave=0;
            $user->save();
            return response()->json(['success'=> __('admin.not_allowed')]);
    	}
        
    }

    public function enable_leave(Request $request, $id)
    {
    	if($id == 1 )
    	{
            return response()->json(['failed'=>'not authorized to disable or enable']);
    	}
    	else
    	{
    		$user= AttendLeaveSetting::find($id);
    		$user->enable_before_leave=1;
            $user->save();
            return response()->json(['success'=> __('admin.allowed')]);
    	}
        
    }

}
