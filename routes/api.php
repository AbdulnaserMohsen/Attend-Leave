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


Route::get('success', 'API\AuthController@success');
Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

Route::group(['middleware' => 'auth:api'], function() 
{
	//profile
    Route::get('logout', 'API\AuthController@logout');
    Route::get('user', 'API\AuthController@user');
    Route::post('update_profile', 'API\AuthController@update_profile');
    Route::post('update_password', 'API\AuthController@update_password');
    

    //attend and leave
    Route::get('home', 'API\HomeController@home');
    Route::post('user_attend', 'API\HomeController@user_attend');
    Route::post('user_leave', 'API\HomeController@user_leave');
    Route::post('user_year_months_statistics', 'API\HomeController@user_year_months_statistics');
    Route::post('user_statictics', 'API\HomeController@user_statictics');
});
