<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Email_Username implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (preg_match('/^(?=[a-zA-Z0-9._]{3,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/',$value) || (preg_match('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/',$value))) ? 1 : 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if(app()->getLocale()=="ar" )
            return 'اسم المسستخدم يجب ان يكون مثل البريد الألكتروني أو يتكون من حروف وارقام وعلامة( _ )و( . ) نقطة';
        else
            return 'username must be like email abc@yz.com or just characters , numbers , (_) underscore and (.)dot';
    }
}
