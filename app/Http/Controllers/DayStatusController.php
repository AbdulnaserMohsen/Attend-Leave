<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DayStatus;
use App\Weekends;
use Cache;	
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\About;

class DayStatusController extends Controller
{
	private $days;
	public function __construct()
    {
	   	$this->days = collect([ 
					 	 ['id' => 1 , 'day_ar' => 'الاحد','day_en' => 'Sunday'],
					 	 ['id' => 2 , 'day_ar' => 'الاثنين','day_en' => 'Monday'],
					 	 ['id' => 3 , 'day_ar' => 'الثلاثاء','day_en' => 'Tuesday'],
					 	 ['id' => 4 , 'day_ar' => 'الاربعاء','day_en' => 'Wednesday'],
					 	 ['id' => 5 , 'day_ar' => 'الخميس','day_en' => 'Thursday'],
                         ['id' => 6 , 'day_ar' => 'الجمعة','day_en' => 'Friday'], 
                         ['id' => 7 , 'day_ar' => 'السبت','day_en' => 'Saturday']]);
    }
    public function day_statuses($paginate)
    {
    	if ($paginate <= 0) 
    	{
    		$paginate = Cache::get('day_status_paginate', function() { return 10; });
    	}
    	else
    	{
    		Cache::forever('day_status_paginate', $paginate);
    	}
        
        $day_statuses=DayStatus::paginate($paginate);
       	$weekends = Weekends::all();
       	//dd($weekends[0]->day_en);
       	$days = $this->days;
       	//dd($days[1]['day_ar']);
        
        $home =  About::first();
       	return view('table_day_status',compact('day_statuses','weekends','days','home'));
    }

    public function update_weekends($ids)
    {
    	$ids = explode(',', $ids);
    	//dd($ids);
    	$weekends = collect();
    	foreach ($ids as $id) 
    	{
    		$weekends->push(['id' =>$this->days[$id-1]['id'] , 'day_ar' =>$this->days[$id-1]['day_ar'] , 'day_en' => $this->days[$id-1]['day_en'], 'created_at' =>Carbon::now(),  'updated_at' => Carbon::now()]);
    	}
    	$weekends = $weekends->toArray();
    	
    	try 
    	{
    		Weekends::truncate();
    		Weekends::insert($weekends);
    		return response()->json(['success'=>__('admin.updated')]);
    	} 
    	catch (Exception $e) 
    	{
    		return response()->json(['failed'=>$e]);
    	}
            
    	    
    }
    

   
    protected function validator(array $data)
    {
       return Validator::make($data, [
            'name_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic}]+$/u'],
            'name_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
        ]);
    }

    public function add_day_status(Request $request)
    {
    	$this->validator($request->all())->validate();
    	
        $day_status= new DayStatus();  
        $day_status->name_ar=$request->get('name_ar');
        $day_status->name_en=$request->get('name_en');
        $day_status->save();
        return response()->json(['success'=>'added']);
    }

    public function update_day_status(Request $request, $id)
    {
    	if($id == 1 || $id == 2)
    	{
            return response()->json(['failed'=>'not authorized to update']);
    	}
    	else
    	{
    		$this->validator($request->all())->validate();

            $day_status= DayStatus::find($id);
            $day_status->name_ar=$request->get('name_ar');
            $day_status->name_en=$request->get('name_en');
            $day_status->save();
            return response()->json(['success'=>'updated']);
    	}        
    }

    public function delete_day_status($id)
    {
    	if($id == 1 || $id == 2)
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		$day_status = DayStatus::find($id);
            $day_status->delete();
            return response()->json(['success'=>'deleted']);
    	}
        
    }

    public function delete_all_day_statuses($ids)
    {
    	$ids = explode(',', $ids);
    	if(in_array(1,$ids) || in_array(2,$ids) )
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		DayStatus::whereIn('id',$ids)->delete();
            return response()->json(['success'=>"deleted all"]);
    	}

    }

}
