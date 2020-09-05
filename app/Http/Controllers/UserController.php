<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Job;
use Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\rules\Email_Username;
use Illuminate\Validation\Rule;
use App\About;

class UserController extends Controller
{
	
	public function change_password()
    {
        $home =  About::first();
        return view('auth.passwords.reset_password',compact('home'));
    }

    protected function validator(array $data)
    {
       return Validator::make($data, [
            'current_password' => ['required', 'password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function update_password(Request $request)
    {
    	$this->validator($request->all())->validate();

    	User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password),'reset_pass' => 0]);
        \Auth::logout();
    	return redirect()->route('login')->with('success', 'Password change successfully.');
    }

    public function users($paginate)
    {
    	
    	if ($paginate <= 0) 
    	{
    		$paginate = Cache::get('user_paginate', function() { return 10; });
    	}
    	else
    	{
    		Cache::forever('user_paginate', $paginate);
    	}
        
        $users=User::where('type',0)->paginate($paginate);
        $jobs=Job::whereNotIn('id',[1000,2000,3000])->get();
        $home =  About::first();
        return view('table_users',compact('users','jobs','home'));
    }

    protected function validator_full_user(array $data,$id)
    {
       return Validator::make($data, [
            'name_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic}]+$/u'],
            'name_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
            'slct' => ['required','exists:jobs,id'],
            'user_name_register' => ['required', 'string', 'max:255', 'unique:users,user_name,'.$id.',id' , new Email_Username ],
            'password_register' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    protected function validator_password(array $data)
    {
       return Validator::make($data, [
            'password_register' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    public function update_user(Request $request, $id)
    {
    	if($id == 1 || $id == 2 || $id == 3 )
    	{
            return response()->json(['failed'=>'not authorized to update']);
    	}
    	else
    	{
    		$user= User::find($id);
    		if($user->reset_pass == 1)
    		{
    			$this->validator_full_user($request->all(),$id)->validate();

	            $user->name_ar=$request->get('name_ar');
	            $user->name_en=$request->get('name_en');
	            $user->job_id=$request->get('slct');
	            $user->user_name=$request->get('user_name_register');
	            $user->password=Hash::make($request->get('password_register'));
	            $user->reset_pass=1;

    		}
    		else
    		{
    			$this->validator_password($request->all())->validate();

    			$user->password=Hash::make($request->get('password_register'));
	            $user->reset_pass=1;
    		}

            $user->save();
            return response()->json(['success'=>'updated']);
    	}

        
    }

    public function delete_user($id)
    {
    	if($id == 1 || $id == 2 || $id == 3 )
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		$user = User::find($id);
            $user->delete();
            return response()->json(['success'=>'deleted']);
    	}
        
    }

    public function delete_all_users($ids)
    {
    	$ids = explode(',', $ids);
    	if( in_array(1,$ids) || in_array(2,$ids) || in_array(3,$ids) )
    	{
            return response()->json(['failed'=>'not authorized to delete']);
    	}
    	else
    	{
    		User::whereIn('id',$ids)->delete();
            return response()->json(['success'=>"deleted all"]);
    	}

    }

    public function disable_account(Request $request, $id)
    {
    	if($id == 1 || $id == 2 || $id == 3 )
    	{
            return response()->json(['failed'=>'not authorized to disable or enable']);
    	}
    	else
    	{
    		$user= User::find($id);
    		$user->disable_account=1;
            $user->save();
            return response()->json(['success'=> __('admin.disabled')]);
    	}
        
    }

    public function enable_account(Request $request, $id)
    {
    	if($id == 1 || $id == 2 || $id == 3 )
    	{
            return response()->json(['failed'=>'not authorized to disable or enable']);
    	}
    	else
    	{
    		$user= User::find($id);
    		$user->disable_account=0;
            $user->save();
            return response()->json(['success'=> __('admin.enabled')]);
    	}
        
    }




}
