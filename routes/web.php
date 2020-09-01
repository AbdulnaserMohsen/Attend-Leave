<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'MainController@index')->name('index');

Route::get('lang/{locale}', 'MainController@lang');

Route::middleware(['MonitorAdmin'])->group(function () 
{

Route::get('/admin', 'MainController@admin')->name('admin');

//jobs
Route::get('/jobs/{paginate}', 'JobController@jobs')->name('jobs');
Route::post('/add_job', 'JobController@add_job')->name('add_job');
Route::post('/update_job/{id}', 'JobController@update_job')->name('update_job');
Route::get('/delete_job/{id}', 'JobController@delete_job')->name('delete_job');
Route::get('/delete_all_jobs/{ids}', 'JobController@delete_all_jobs')->name('delete_all_jobs');

//user
Route::get('/users/{paginate}', 'UserController@users')->name('users');
Route::post('/update_user/{id}', 'UserController@update_user')->name('update_user');
Route::get('/delete_user/{id}', 'UserController@delete_user')->name('delete_user');
Route::get('/delete_all_users/{ids}', 'UserController@delete_all_users')->name('delete_all_users');
Route::get('/disable_account/{id}', 'UserController@disable_account')->name('disable_account');
Route::get('/enable_account/{id}', 'UserController@enable_account')->name('enable_account');

//attend&leave
Route::get('/attend_leave/', 'SettingController@attend_leave')->name('attend_leave');
Route::get('/attend_leave/settings/{paginate}', 'SettingController@settings')->name('settings');
Route::post('/add_setting', 'SettingController@add_setting')->name('add_setting');
Route::get('/delete_setting/{id}', 'SettingController@delete_setting')->name('delete_setting');
Route::get('/delete_all_settings/{ids}', 'SettingController@delete_all_settings')->name('delete_all_settings');
Route::get('/disable_attend/{id}', 'SettingController@disable_attend')->name('disable_attend');
Route::get('/enable_attend/{id}', 'SettingController@enable_attend')->name('enable_attend');
Route::get('/disable_leave/{id}', 'SettingController@disable_leave')->name('disable_leave');
Route::get('/enable_leave/{id}', 'SettingController@enable_leave')->name('enable_leave');

//Day_statuses
Route::get('/attend_leave/day_statuses/{paginate}', 'DayStatusController@day_statuses')->name('day_statuses');
Route::post('/add_day_status', 'DayStatusController@add_day_status')->name('add_day_status');
Route::post('/update_day_status/{id}', 'DayStatusController@update_day_status')->name('update_day_status');
Route::get('/delete_day_status/{id}', 'DayStatusController@delete_day_status')->name('delete_day_status');
Route::get('/delete_all_day_statuses/{ids}', 'DayStatusController@delete_all_day_statuses')->name('delete_all_day_statuses');
//weekends
Route::get('/update_weekends/{id}', 'DayStatusController@update_weekends')->name('update_weekends');


//User_statuses
Route::get('/attend_leave/user_statuses/{paginate}', 'UserStatusController@user_statuses')->name('user_statuses');
Route::post('/add_user_status', 'UserStatusController@add_user_status')->name('add_user_status');
Route::post('/update_user_status/{id}', 'UserStatusController@update_user_status')->name('update_user_status');
Route::get('/delete_user_status/{id}', 'UserStatusController@delete_user_status')->name('delete_user_status');
Route::get('/delete_all_user_statuses/{ids}', 'UserStatusController@delete_all_user_statuses')->name('delete_all_user_statuses');

//calender
Route::get('/attend_leave/calendar', 'CalendarController@calendar')->name('calendar');
Route::get('/change_year/{year}', 'CalendarController@change_year')->name('change_year');
Route::post('/add_vacation', 'CalendarController@add_vacation')->name('add_vacation');
Route::get('/delete_vacation/{id}', 'CalendarController@delete_vacation')->name('delete_vacation');

//attendLeave today & history
Route::get('/attend_leave/{date}/{paginate}', 'AttendLeaveController@day')->name('day');
Route::post('/attend_leave/update_attend_leave/{id}', 'AttendLeaveController@update_attend_leave')->name('update_attend_leave');

//all user statictics
Route::get('/year_months_statistics/{year}', 'AttendLeaveController@year_month_statistics')->name('year_month_statistics');
Route::get('/attend_leave/statictics/{year}/{month}/{worker_paginate}/{table_paginate}', 'AttendLeaveController@statictics')->name('statictics');
Route::get('/attend_leave/user_atted_all/{paginate}', 'UserStatusController@user_atted_all')->name('user_atted_all');



});




Route::middleware(['auth'])->group(function () 
{
Route::get('/user/change_password', 'UserController@change_password')->name('change_password');
Route::post('/user/update_password', 'UserController@update_password')->name('update_password');
Route::get('/user/profile', 'HomeController@profile')->name('profile');
Route::post('/update_profile', 'HomeController@update_profile')->name('update_profile');

//user attend and leave
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user_attend', 'HomeController@user_attend')->name('user_attend');
Route::post('/user_leave', 'HomeController@user_leave')->name('user_leave');

//statistics
Route::get('/user_year_months_statistics/{year}', 'HomeController@user_year_months_statistics')->name('user_year_months_statistics');
Route::get('/user_statictics/{year}/{month}/{table_paginate}', 'HomeController@user_statictics')->name('user_statictics');

});
Auth::routes();


