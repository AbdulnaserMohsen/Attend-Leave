<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use App\rules\Email_Username;


class AuthController extends Controller
{
   	public function success(Request $request)
    {
    	return response()->json(['message' => 'Api executed Successfully'], 201);
    }
   	/**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
   	protected function validator(array $data)
    {
       return Validator::make($data, [
            'name_ar' => ['required', 'string', 'max:255' , 'regex:/^[\p{Arabic} ]+$/u'],
            'name_en' => ['required', 'string', 'max:255' , 'regex:/^[a-zA-Z ]+$/u'],
            'slct' => ['required','exists:jobs,id'],
            'user_name_register' => ['required', 'string', 'max:255', 'unique:users,user_name', new Email_Username ],
            'password_register' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) 
        { 
            return response()->json(['error'=>$validator->errors()], 401); 
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
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
     * @param  [string] email
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
     *
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
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }


}
