<?php

use Illuminate\Support\Facades\Route;
use App\User;
use GuzzleHttp\Client;

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

Route::get('/callback', function () {
    return true;
});

Route::get('/users', function () {
    return User::all();
});

Route::get('/auth/redirect', function(){
    $query = http_build_query([
        'client_id' => 5,
        'redirect_uri' => url('callback'),
        'response_type' => 'code',
        'scope' => '',
    ]);
    
    return redirect('http://localhost:8000/oauth/authorize?' . $query);
});

Route::get('/callback', function (Request $request) {
    /*$state = $request->session()->pull('state');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class
    );*/

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 5,
            'client_secret' => '7IJD8V8FKGzlwlvtixmfNUvRQ4avRvjFEVkBgCnH',
            'redirect_uri' => 'http://localhost:8000/callback',
            'code' => 'def502000f82ff15ffc459287be6060b566163c27ab092d26d33d5fe7f271f29c0420bf3f1642b9b3bf0d3eada2035f5a50c7e3bda0d59af0b46c88f58750b1d179b36b99f1641d0dd6a37eb8bd329a071305116a9dd9680f7b04bb6c5339388152a7eb52cceef0e19e82b092693dc6bde95a592239f342cf90c6e89aad20121f494bd92de2a90aa977064ed67c2b57d17557d8877230a9b73bb594ad0ae40bffa32c7c1dfbfa19967731c6dff5fc273575d926d092084251a414a85ed1a6595b71f463b72e580d502324e182a12784064ecc248fe9a54084b14c1975e9305c2eaae156b9c0c744d6078cd188f7472634b886a194b5da58d7cc921075fba3a9ab6391164a8084f2bf83d7d86a4729352185a7c18d3d729d790ce00305d6e01ddd4854931f5017ba7e82226c6f833ebdec9ee9fe5ac9dbd7b6ac4a5dd8836ffa5f954d51bd525eba4dd8020dddd6c1885a297ec3b93fde3eb990d750ef81a',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
