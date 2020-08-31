<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Job;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\rules\Email_Username;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data,$type,$reset_pass)
    {
        //dd($type,$reset_pass);
        return User::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'job_id' => $data['slct'],
            'type' => $type,
            'reset_pass'=>$reset_pass,
            'disable_account'=>0,
            'user_name' => $data['user_name_register'],
            'password' => Hash::make($data['password_register']),
        ]);
    }

    //me
    protected function redirectTo()
    {
        $registered = true;
        return route('login', compact('registered'));
    }
}
