<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api", 
        ["except" => [
            "login",
             "signUp"
             ]]);
    }
    public function signUp(Request $request)
    {
        $request = Validator::make($request->all(), [
            "name" => "required|max:25",
            "username" => "required|max:50|unique:users",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
            "password_confirmation" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => $request->password,
            "password_confirmation" => $request->password_confirmation,
        ]);
        return response()->json(
            [
                "message" => "User successfully registered",
                "user" => $user,
            ],
            201
        );
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!($token = auth()->attempt($validator->validated()))) {
            return response()->json(["error" => "Unauthorized"], 401);
        }
        return $this->createNewToken($token);
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" =>
                auth()
                    ->factory()
                    ->getTTL() * 60,
            "user" => auth()->user(),
        ]);
    }
}
