<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DayStatus;
use App\Weekends;
use App\Calender;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App;
use Cache;
use App\About;

class CalendarController extends Controller
{
    public function calendar(Request $request)
    {
        $daystatuses = DayStatus::whereNotIn('id',[1,2])->get();
        $weekends = Weekends::pluck('id')->toArray();
        for($i=0; $i<count($weekends); $i++) 
        {
            $weekends[$i] -=1;
        }
        //dd($weekends);

        if ($request->has('year')) 
        {
            //dd($request->get('year') ,$request );
            $year =(int) $request->get('year');
            $month =(int) $request->get('month');
            $events = Calender::whereYear('date','=',$year)->whereMonth('date','=',$month)->where('day_status_id','!=' , 1)->orHas('attend_leave')->get();
            //dd($events);
            $current_date = $request->get('date');
        }
        else
        {
            $current_date = Carbon::now();
            $year = $current_date->year;
            $month = $current_date->month;
            $events = Calender::whereYear('date','=',$year)->whereMonth('date','=',$month)->where('day_status_id','!=' , 1)->orHas('attend_leave')->get();
            //dd($events);
            
        }
        
        $daily_event =[];
        $loop=0;
        foreach ($events as $event) 
        {
            //dd($vacation->day_status->name_en);
            if(App::isLocale('ar')){$event_name = $event->day_status->name_ar;}
            else{$event_name = $event->day_status->name_en;}
            
            if($event->day_status_id == 1)
            {
                $daily_event[$loop] =
                [
                    "id"=> $event->id,
                    "name" => $event_name,
                    "date" => $event->date,
                    "type" =>"event",
                    "everyYear" =>  false,
                    "url" => route('day',['date'=>Carbon::parse($event->date)->format('Y-m-d'),'paginate'=>Cache::get('attend_today_paginate') ]),
                ];
            }
            else
            {
               $daily_event[$loop] =
                [
                    "id"=> $event->id,
                    "name" => $event_name,
                    "date" => $event->date,
                    "type" =>"holiday",
                    "everyYear" =>  false,
                ]; 
            }
            
            $loop++;
        }
        if ($request->has('year')) 
        {
            //dd($vacations , $year);
            $home =  About::first();
            $returnHTML = view('partial.calendar',compact('daystatuses','weekends','events','daily_event','year','current_date','month','home'))->render();
            return response()->json(['success'=>__('admin.done'),'events'=>$events,'daily_event'=>$daily_event,'year'=>$year,'html'=>$returnHTML]);
            /*$success = __('admin.done');
            return view('calendar',compact('success','daystatuses','weekends','vacations','vacations_events','year','current_date'));*/
        }
        else
        {
            $home =  About::first();
            return view('calendar',compact('daystatuses','weekends','events','daily_event','year','current_date','month','home'));
        }
    }
    /*public function calendar1(Request $request)
    {
    	$daystatuses = DayStatus::whereNotIn('id',[1,2])->get();
    	$weekends = Weekends::pluck('id')->toArray();
    	for($i=0; $i<count($weekends); $i++) 
    	{
    		$weekends[$i] -=1;
    	}
    	//dd($weekends);

    	if ($request->has('year')) 
    	{
    		//dd($request->get('year') ,$request );
    		$year =(int) $request->get('year');
        	$vacations = Calender::whereNotIn('day_status_id',[1,2])->whereYear('date','=',$year)->get();
        	//dd($vacations);
        	$current_date = $request->get('date');
		}
		else
		{
			$current_date = Carbon::now();
			$year = $current_date->year;
        	$vacations = Calender::whereNotIn('day_status_id',[1,2])->whereYear('date','=',$year)->get();
		}
    	
        $vacations_events =[];
        $loop=0;
        foreach ($vacations as $vacation) 
        {
        	//dd($vacation->day_status->name_en);
        	if(App::isLocale('ar')){$vacation_name = $vacation->day_status->name_ar;}
        	else{$vacation_name = $vacation->day_status->name_en;}
    		
    		$vacations_events[$loop] =
    		[
				"id"=> $vacation->id,
				"name" => $vacation_name,
				"date" => $vacation->date,
			    "type" =>"holiday",
			    "everyYear" =>  false
			];
			$loop++;
    	}
    	if ($request->has('year')) 
    	{
    		//dd($vacations , $year);
    		$returnHTML = view('partial.calendar',compact('daystatuses','weekends','vacations','vacations_events','year','current_date'))->render();
    		return response()->json(['success'=>__('admin.done'),'vacations'=>$vacations,'vacations_events'=>$vacations_events,'year'=>$year,'html'=>$returnHTML]);
    		/*$success = __('admin.done');
    		return view('calendar',compact('success','daystatuses','weekends','vacations','vacations_events','year','current_date'));*/
    	/*}
    	else
    	{
    		return view('calendar1',compact('daystatuses','weekends','vacations','vacations_events','year','current_date'));
    	}
    	
        
    }*/

    protected function validator(array $data)
    {
       return Validator::make($data, [
            'date' => ['required', 'date'],
            'slct' => ['required','exists:App\DayStatus,id'],
        ]);

    }
    
    public function add_vacation(Request $request)
    {
    	$this->validator($request->all())->validate();
    	//dd($request);
        $vacation= Calender::firstOrNew(array('date' => $request->get('date')));  
        //$vacation->date=$request->get('date');
        $vacation->day_status_id=$request->get('slct');
        $vacation->save();
        $id = $vacation->id;
        $date = $vacation->date;
        if(App::isLocale('ar')){$vacation_name = $vacation->day_status->name_ar;}
        else{$vacation_name = $vacation->day_status->name_en;}
        if($request->get('type') == "add")
        {
        	return response()->json(['success'=>__('admin.added'),'id'=>$id,'date'=>$date,'vacation_name'=>$vacation_name,'type'=>'add']);
        }
        else
        {
        	return response()->json(['success'=>__('admin.updated'),'id'=>$id,'date'=>$date,'vacation_name'=>$vacation_name,'type'=>'update']);
        }
        
    
    }

    
    
    public function delete_vacation(Request $request,$id)
    {
    	$vacation = Calender::find($id);
        //$vacation->delete(); //make it work day not delete it
        
        //dd(Carbon::parse($vacation->date)->format('l'));
        $weekends = Weekends::pluck('day_en')->toArray();
        if(in_array(Carbon::parse($vacation->date)->format('l'),$weekends))//if weekend
        {
        	$vacation->day_status_id = 2;	
        }
        else
        {
        	$vacation->day_status_id = 1;
        }
        $current_date = $vacation->date;
        $vacation->save();
        return response()->json(['success'=>__('admin.deleted'),'current_date'=>$current_date]);

    }
}
