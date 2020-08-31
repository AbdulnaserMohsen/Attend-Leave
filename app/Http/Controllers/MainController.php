<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;

use Cache;
use App\User;
use App\Job;
use App\User_Status;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\AttendLeaveSetting;
use App\UserStatus;
use App\DayStatus;
use App\Weekends;
use App\AttendLeave;
use App\Calender;



class MainController extends Controller
{
    protected function init()
    {
        //inite job
        if(!Job::find(1))
        {
            $job= new Job();
            $job->id=1;
            $job->job_ar="معلم";
            $job->job_en="Teacher";
            $job->save();            
        }

        if(!Job::find(1000))
        {
            $job= new Job();
            $job->id=1000;
            $job->job_ar="مراقب";
            $job->job_en="monitor";
            $job->save();
        } 

        if(!Job::find(2000))
        {
            $job= new Job();
            $job->id=2000;
            $job->job_ar="مدير";
            $job->job_en="Admin";
            $job->save();
        }

        if(!Job::find(3000))
        {
            $job= new Job();
            $job->id=3000;
            $job->job_ar="مطور";
            $job->job_en="Developer";
            $job->save();
        }

        Cache::forever('job_paginate', 10);

        //inite user superadmin
        if(!User::find(1))
        {
            $user= new User();
            $user->id=1;
            $user->name_ar="مطور1";
            $user->name_en="Developer1";
            $user->job_id=3000;
            $user->user_name="The_Greatest";
            $user->password=Hash::make("THEgreatest4eVer");
            $user->type=3;
            $user->reset_pass =0;
            $user->save();
        }
        //inite user monitor
        if(!User::find(2))
        {
            $user= new User();
            $user->id=2;
            $user->name_ar="مدير1";
            $user->name_en="Admin1";
            $user->job_id=2000;
            $user->user_name="The_Admin";
            $user->password=Hash::make("THE_admin");
            $user->type=2;
            $user->reset_pass =0;
            $user->save();
        }
        //inite user admin
        if(!User::find(3))
        {
            $user= new User();
            $user->id=3;
            $user->name_ar="مراقب1";
            $user->name_en="monitor1";
            $user->job_id=1000;
            $user->user_name="The_Monitor";
            $user->password=Hash::make("THE_Monitor");
            $user->type=1;
            $user->reset_pass =0;
            $user->save();
        }

        Cache::forever('user_paginate', 10);

        //settings
        if(!AttendLeaveSetting::find(1))
        {
            $setting = new AttendLeaveSetting();
            $setting->id=1;
            $setting->attend_time_from='06:00';
            $setting->attend_time_to='9:00';
            $setting->leave_time_from='13:00';
            $setting->leave_time_to='18:00';
            $setting->save();
        }
        Cache::forever('setting_paginate', 10);

        //status
        if(!UserStatus::find(1))
        {
            $status = new UserStatus();
            $status->id=1;
            $status->name_en="Attend";
            $status->name_ar="حضور";
            $status->save();
        }
        if(!UserStatus::find(2))
        {
            $status = new UserStatus();
            $status->id=2;
            $status->name_en="Leave";
            $status->name_ar="إنصراف";
            $status->save();
        }
        if(!UserStatus::find(3))
        {
            $status = new UserStatus();
            $status->id=3;
            $status->name_en="Absense";
            $status->name_ar="غياب";
            $status->save();
        }
        if(!UserStatus::find(4))
        {
            $status = new UserStatus();
            $status->id=4;
            $status->name_en="Sick leave";
            $status->name_ar="اجازه مرضية ";
            $status->save();
        }
        if(!UserStatus::find(5))
        {
            $status = new UserStatus();
            $status->id=5;
            $status->name_en="attend late accepted";
            $status->name_ar="أذن بالتاخر في الحضور ";
            $status->save();
        }
        if(!UserStatus::find(6))
        {
            $status = new UserStatus();
            $status->id=6;
            $status->name_en="leave early accepted";
            $status->name_ar="أذن بالانصراف مبكرا";
            $status->save();
        }

        Cache::forever('user_status_paginate', 10);

        if(!DayStatus::find(1))
        {
            $status = new DayStatus();
            $status->id=1;
            $status->name_en="work";
            $status->name_ar="عمل";
            $status->save();
        }
        if(!DayStatus::find(2))
        {
            $status = new DayStatus();
            $status->id=2;
            $status->name_en="weekends";
            $status->name_ar="عطلات نهاية الأسبوع";
            $status->save();
        }
        if(!DayStatus::find(3))
        {
            $status = new DayStatus();
            $status->id=3;
            $status->name_en="Eid al-Fitr";
            $status->name_ar="عيد الفطر";
            $status->save();
        }
        if(!DayStatus::find(4))
        {
            $status = new DayStatus();
            $status->id=4;
            $status->name_en="Eid al-Adha";
            $status->name_ar="عيد الاضحى";
            $status->save();
        }
        if(!DayStatus::find(5))
        {
            $status = new DayStatus();
            $status->id=5;
            $status->name_en="25th January Revolution";
            $status->name_ar="ثوره 25 يناير";
            $status->save();
        }

        if(!DayStatus::find(6))
        {
            $status = new DayStatus();
            $status->id=6;
            $status->name_en="Hijri New Year";
            $status->name_ar="بداية السنة الهجرية ";
            $status->save();
        }

        if(!DayStatus::find(7))
        {
            $status = new DayStatus();
            $status->id=7;
            $status->name_en="New Year";
            $status->name_ar="بداية السنة الميلادية";
            $status->save();
        }
        Cache::forever('day_status_paginate', 10);

        if(!Weekends::find(6))
        {
            $weekend = new Weekends();
            $weekend->id=6;
            $weekend->day_en="Friday";
            $weekend->day_ar="الجمعة";
            $weekend->day_status_id=2;
            $weekend->save();
        }
        Cache::forever('day_status_paginate', 10);
        Cache::forever('attend_today_paginate', 10);
        Cache::forever('worker_paginate', 5);
        Cache::forever('table_paginate', 5);



    }

    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    public function index()
    {
        //dd(!Job::find(1) || !Job::find(1000) || !Job::find(2000) || !Job::find(3000) || !User::find(1) || !User::find(2) || !User::find(3));
          
        if(!Job::find(1) || !Job::find(1000) || !Job::find(2000) || !Job::find(3000) || !User::find(1) || !User::find(2) || !User::find(3) || !AttendLeaveSetting::find(1) || !UserStatus::find(1) || !UserStatus::find(2)||!UserStatus::find(3)||!UserStatus::find(4) ||!UserStatus::find(5) ||!UserStatus::find(6) ||!DayStatus::find(1) ||!DayStatus::find(2) ||!DayStatus::find(3) ||!DayStatus::find(4) ||!DayStatus::find(5) ||!DayStatus::find(6) ||!DayStatus::find(7) ||!Weekends::find(6))
        {
            //dd(User::find(1));
            $this->init();
        }

        return view('index');
    }

    public function admin()
    {
       $users_count = User::where('type',0)->count();
       $jobs_count = Job::whereNotIn('id',[1000,2000,3000])->count();
       $today = Carbon::now()->format('Y-m-d');
       $date = Calender::where('date',$today)->first();
       $today_count = AttendLeave::where('calender_id',$date->id)->Where(function($query) {
                $query->where('attend_user_status_id',"!=",5)
                      ->orwhere('leave_user_status_id',"!=",5);
            })->count();

       $monitors_count = User::where('type',1)->count()-1;
       $admins_count = User::where('type',2)->count()-1;
       $super_admins_count = User::where('type',3)->count()-1;

       return view('admin',compact('users_count','jobs_count','today_count','monitors_count','admins_count','super_admins_count'));
    }
}
