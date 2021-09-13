<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Traits\Auth\AuthResponse;

class UserController extends Controller
{
    private $role;
    use AuthResponse;
    public function register(UserRegisterRequest $request)
    {
      
        $user = new User([
            'fullname' => $request->input('fullname'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'show_pass' => $request->input('password'),
            'country' => $request->input('country'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully Created user'
        ], 201);
    }

    public function login(UserLoginRequest $request)
    {
       
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 500);
        }
        return response()->json([
            'token' => $token
        ], 200);
    
}

public function changePassword(Request $request)
{

    $request->validate([
        'old_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::find( auth('api')->user()->id);

    if ($request->old_password ==  auth('api')->user()->show_pass) {
    
        $user->update(['password' => bcrypt($request->password), 'show_pass' => $request->password]);
        return response()->json(['message'=> 'Password Changed!'], 200);

    } else {
        return response()->json(['message'=> 'Invalid Current Password'], 200);
    }
}

}
