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
/*
    jwt
    //register
    http://localhost:8000/api/register?name=cat&email=cat@mail.com&password=12345678&c_password=12345678
    //login and get token
    http://localhost:8000/api/login?email=cat@mail.com&password=12345678 
    //add bearer to access
    http://localhost:8000/api/details

    password
    //create client and get id and secret
    php artisan passport:client --password
    //use client information to get token
    http://localhost:8000/oauth/token
    //add bearer to access
    http://localhost:8000/api/details
*/
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('time', 'ApiController@time');
    Route::post('logout', 'UserController@logout');
    Route::post('details', 'UserController@details');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
