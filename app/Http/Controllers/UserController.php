<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller 
{
    public $successStatus = 200;

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        //$success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus); 
    }

    public function login(Request $request){
        $input = $request->only('email', 'password');
        $token = null;

        if(!$token = auth('api')->attempt($input)){ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
        else{  
            $success['token'] =  $token; 
            return response()->json(['success' => $success], $this->successStatus); 
        } 
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
        //Auth::guard('api')->logout();
        //return response()->json(['success' => $user], $this->successStatus); 
    }

    public function details() 
    { 
        //$user = Auth::guard('api')->user();
        //$token = JWTAuth::user()->token();
        //$bearerToken = JWTAuth::bearerToken();
        return response()->json(['success' => auth('api')->user()], $this->successStatus); 
    } 
}