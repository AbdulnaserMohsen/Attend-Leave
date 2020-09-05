<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Job;
use Illuminate\Support\Facades\Validator;
use Cache;
use App\About;

class JobController extends Controller
{

    public function jobs($paginate)
    {
    	
        if ($paginate <= 0) 
    	{
    		$paginate = Cache::get('job_paginate', function() { return 10; });
    	}
    	else
    	{
    		Cache::forever('job_paginate', $paginate);
    	}
        
        $jobs=Job::whereNotIn('id',[1000,2000,3000])->paginate($paginate);
        $home =  About::first();
        return view('table',compact('jobs','home'));
    }

    protected function validator(array $data)
    {
       return Validator::make($data, [
            'job_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic} ]+$/u'],
            'job_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
        ]);

    }

    public function add_job(Request $request)
    {
    	$this->validator($request->all())->validate();
    	
    	/*$validator = \Validator::make($request->all(),[
            'job_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic}]+$/u'],
            'job_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
        ]);


        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()->all()]);
        }*/
    	

        $job= new Job();
        $job->job_ar=$request->get('job_ar');
        $job->job_en=$request->get('job_en');
        $job->save();
        return response()->json(['success'=>'added']);
    }

    public function update_job(Request $request, $id)
    {
    	if($id == 1 || $id == 1000 || $id == 2000 || $id == 3000)
    	{
            return response()->json(['failed'=>'not authorized to update']);
    	}
    	else
    	{
    		$this->validator($request->all())->validate();

            $job= Job::find($id);
            $job->job_ar=$request->get('job_ar');
            $job->job_en=$request->get('job_en');
            $job->save();
            return response()->json(['success'=>'updated']);
    	}

        
    }

    public function delete_job($id)
    {
    	if($id == 1 || $id == 1000 || $id == 2000 || $id == 3000)
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		$job = Job::find($id);
            $job->delete();
            return response()->json(['success'=>'deleted']);
    	}
        
    }

    public function delete_all_jobs($ids)
    {
    	$ids = explode(',', $ids);
    	if(in_array(1,$ids) || in_array(1000,$ids) || in_array(2000,$ids) || in_array(3000,$ids))
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		Job::whereIn('id',$ids)->delete();
            return response()->json(['success'=>"deleted all"]);
    	}

    }



}
