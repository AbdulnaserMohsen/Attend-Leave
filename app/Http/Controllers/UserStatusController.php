<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserStatus;
use Illuminate\Support\Facades\Validator;
use Cache;

class UserStatusController extends Controller
{
    public function user_statuses($paginate)
    {
    	if ($paginate <= 0) 
    	{
    		$paginate = Cache::get('user_status_paginate', function() { return 10; });
    	}
    	else
    	{
    		Cache::forever('user_status_paginate', $paginate);
    	}
        $user_statuses=UserStatus::paginate($paginate);

       	return view('table_user_status',compact('user_statuses'));
    }

       
    protected function validator(array $data)
    {
       return Validator::make($data, [
            'name_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic}]+$/u'],
            'name_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
        ]);
    }

    public function add_user_status(Request $request)
    {
    	$this->validator($request->all())->validate();
    	
        $user_status= new UserStatus();  
        $user_status->name_ar=$request->get('name_ar');
        $user_status->name_en=$request->get('name_en');
        $user_status->save();
        return response()->json(['success'=>'added']);
    }

    public function update_user_status(Request $request, $id)
    {
    	if($id == 1 || $id == 2 || $id == 3)
    	{
            return response()->json(['failed'=>'not authorized to update']);
    	}
    	else
    	{
    		$this->validator($request->all())->validate();

            $user_status= UserStatus::find($id);
            $user_status->name_ar=$request->get('name_ar');
            $user_status->name_en=$request->get('name_en');
            $user_status->save();
            return response()->json(['success'=>'updated']);
    	}        
    }

    public function delete_user_status($id)
    {
    	if($id == 1 || $id == 2 || $id == 3)
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		$user_status = UserStatus::find($id);
            $user_status->delete();
            return response()->json(['success'=>'deleted']);
    	}
        
    }

    public function delete_all_user_statuses($ids)
    {
    	$ids = explode(',', $ids);
    	if(in_array(1,$ids) || in_array(2,$ids) || in_array(3,$ids) )
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		UserStatus::whereIn('id',$ids)->delete();
            return response()->json(['success'=>"deleted all"]);
    	}

    }
}
