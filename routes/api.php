<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get('success', 'Api\AuthController@success');
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::group(['middleware' => 'auth:api'], function() 
{
	//profile
    Route::get('logout', 'Api\AuthController@logout');
    Route::get('user', 'Api\AuthController@user');
    Route::post('update_profile', 'Api\AuthController@update_profile');
    Route::post('update_password', 'Api\AuthController@update_password');
    

    //attend and leave
    Route::get('home', 'Api\HomeController@home');
    Route::post('user_attend', 'Api\HomeController@user_attend');
    Route::post('user_leave', 'Api\HomeController@user_leave');
    Route::post('user_year_months_statistics', 'Api\HomeController@user_year_months_statistics');
    Route::post('user_statictics', 'Api\HomeController@user_statictics');
});
