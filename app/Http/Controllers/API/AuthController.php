<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use App\Rules\Email_Username;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
   	public function success(Request $request)
    {
    	return response()->json(['message' => 'Api executed Successfully'], 201);
    }
   	/**
     * Create user
     *
     * @param  [string] name_ar
     * @param  [string] name_en
     * @param  [int] slct
     * @param  [string] user_name_register
     * @param  [string] password_register
     * @param  [string] password_register_confirmation
     * @return [string] message
     */
   	

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic} ]+$/u'],
            'name_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
            'slct' => ['required','exists:jobs,id'],
            'user_name_register' => ['required', 'string', 'max:255', 'unique:users,user_name', new Email_Username ],
            'password_register' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
		if ($validator->fails()) 
		{ 
            return response()->json(['error'=>$validator->errors()], 401); 
        }
        
        $input = $request->all();
        //$input['password_register'] = bcrypt($input['password_register']);
        $user = User::create([
            'name_ar' => $input['name_ar'],
            'name_en' => $input['name_en'],
            'job_id' => $input['slct'],
            'type' => 0,
            'reset_pass'=>0,
            'disable_account'=>0,
            'user_name' => $input['user_name_register'],
            'password' => Hash::make($input['password_register']),
        ]);

        return response()->json(['message' => 'Successfully created user!'], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] user_name
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    
    public function login(Request $request)
    {
    	
    	$validator = Validator::make($request->all(), [ 
            'user_name' => ['required', 'string', 'max:255', new Email_Username ],
            'password' => 'required|string',
            'remember_me' => 'boolean', 
        ]);
		if ($validator->fails()) 
		{ 
            return response()->json(['error'=>$validator->errors()], 401); 
        }


        $credentials = request(['user_name', 'password']);        
        if(!Auth::attempt($credentials))
        {
        	return response()->json(['message' => 'Unauthorized'], 401); 
        }           
		
		$validator = Validator::make($request->all(), [ 
            'user_name' => ['exists:App\User,user_name,disable_account,0' ], 
        ]);
		if ($validator->fails()) 
		{ 
            return response()->json(['error'=>$validator->errors()], 401); 
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;        
        if ($request->remember_me)
        {
        	$token->expires_at = Carbon::now()->addWeeks(1); 
        }
        
        $token->save();        
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)
            ->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     * @authorization  [Bearer ] Access Token
     * @return [string] message
     */
    public function logout(Request $request)
    {
        
        $request->user()->token()->revoke();        
        return response()->json(['message' => 'Successfully logged out']);

    }
  
    /**
     * Get the authenticated User
     *
     * @authorization  [Bearer ] Access Token
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }


    /**
     * update user profile
     *
     * @param  [string] name_ar
     * @param  [string] name_en
     * @param  [int] slct
     * @param  [string] user_name_register
     * @return [string] message
     */
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic} ]+$/u'],
            'name_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
            'slct' => ['required','exists:jobs,id'],
            'user_name_register' => ['required', 'string', 'max:255', 'unique:users,user_name,'.$request->user()->id.',id', new Email_Username ],
        ]);
		if ($validator->fails()) 
		{ 
            return response()->json(['error'=>$validator->errors()], 401); 
        }
        
        $input = $request->all();

        $user = User::where('id', $request->user()->id)->update([
            'name_ar' => $input['name_ar'],
            'name_en' => $input['name_en'],
            'job_id' => $input['slct'],
            'type' => 0,
            'reset_pass'=>0,
            'disable_account'=>0,
            'user_name' => $input['user_name_register'],
        ]);

        return response()->json(['message' => 'Successfully updated user!'], 201);
    }


    /**
     * update password and logout
     *
     * @param  [string] current_password
     * @param  [string] new_password
     * @param  [string] new_password_confirmation
     * @return [string] message
     */
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'current_password' => ['required', 'password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
		if ($validator->fails()) 
		{ 
            return response()->json(['error'=>$validator->errors()], 401); 
        }
        
        $input = $request->all();
        //$input['new_password'] = bcrypt($input['new_password']);

        $user = User::where('id', $request->user()->id)->update(
        	[
        		'password'=> Hash::make($input['new_password']),
        		'reset_pass' => 0,
        	]);

        $request->user()->token()->revoke(); 

        return response()->json(['message' => 'Successfully updated password!'], 201);
    }

}
