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

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/password-grant', function (){
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => env('API_CLIENT_ID'),
            'client_secret' => env('API_CLIENT_SECRET'),
            'username' => env('API_USERNAME'),
            'password' => env('API_PASSWORD'),
            'scope' => '',
    　　],
    ]);
    return json_decode((string)$response->getBody(), true);
});

//password grant test
Route::get('/password-grant-test', function (){
    $accessToken='eyJpdiI6InpNNHhjXC9wWFNwTCt0aGhESnJ3WTVnPT0iLCJ2YWx1ZSI6IlFlN2VuVHljXC9FTlA0OW10WWdVd3MxanJTTTB5RlRlbm5xSFBCa1BTTHhpem9GZmpadGw0bGROTnIyZ3NoZXc2IiwibWFjIjoiZDVjMjg3ODZhNDQxN2IzNTY1MTUyZjA0ODYxZjU5MGViNDg3Nzc2NDFjM2NiNmYwZWMxNDA5N2ZjNTNiODc0MiJ9';
    $http = new GuzzleHttp\Client;
    $response = $http->request('GET', 'http://localhost:8000/api/songs', [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer'.$accessToken,
    　　],
    ]);
    return $response;
});
/*