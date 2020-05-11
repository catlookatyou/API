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
    1. jwt(in auth.php , 'driver' => 'jwt')
    //register
    http://localhost:8000/api/register?name=cat&email=cat@mail.com&password=12345678&c_password=12345678
    [name, email, password, c_password]

    //login and get token
    http://localhost:8000/api/login?email=cat@mail.com&password=12345678 
    [email, password]

    //add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]

    //refresh
    http://localhost:8000/api/refresh
    [Accept => application/json, Authorization => Bearer token]

    //logout
    http://localhost:8000/api/logout
    [Accept => application/json, Authorization => Bearer token]
    ----------------------------------------------------------------
    2. password(in auth.php , 'driver' => 'passport')
    //create client and get id and secret
    php artisan passport:client --password

    //use client information to get token
    http://localhost:8000/oauth/token
    [grant_type => password, client_id, client_secret, username, password, scope]

    //add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]

    //refresh
    http://localhost:8000/oauth/token
    [grant_type => refresh_token, refresh_token, client_id, client_secret, scope]
    ----------------------------------------------------------------
    3. personal(in auth.php , 'driver' => 'passport')
    //create client
    php artisan passport:client --personal

    //create token for user(in api.php)
    Route::get('personal_token', function(){
        $user = App\User::find(1);
        $token = $user->createToken('catlookatyou')->accessToken;
        return $token;
    });

    //add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]
    ----------------------------------------------------------------
    4. authorization_code(in auth.php , 'driver' => 'passport')
    in api server(localhost:8000):
    //create client、client_redirect_uri...
    php artisan passport:client

    in client server:
    //get authorization_code
    http://localhost:8000/oauth/authorize?client_id=&redirect_uri=&response_type=code&scope=
    //in self redirect_uri accept request and get authorization_code

    //add code and get bearer token
    http://localhost:8000/oauth/token
    [grant_type => authorization_code, client_id, client_secret, redirect_uri, code]

    //add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]

    //refresh
    http://localhost:8000/oauth/token
    [grant_type => refresh_token, refresh_token, client_id, client_secret, scope]
*/

Route::post('login', 'UserController@login')->name('api.login');
Route::post('register', 'UserController@register')->name('api.resgister');
Route::group(['middleware' => 'auth:api'], function(){
    Route::apiResource('book', 'api\BookController');
    Route::get('time', 'ApiController@time');
    Route::post('refresh', 'UserController@refresh');
    Route::post('logout', 'UserController@logout');
    Route::post('details', 'UserController@details');
});
Route::get('personal_token', function(){
    $user = App\User::find(1);
    $token = $user->createToken('catlookatyou')->accessToken;
    return $token;
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
