<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request){
        
        // check apakah data user yang diinput ada
        $user = User::where('username',$request->username)->first();

        // check password
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'message'=>'user atau password salah'
            ],401);
        }

        // generate token
        $token = $user->createToken('token')->plainTextToken;

        return new LoginResource([
            'message'=>'success login',
            'user'=>$user,
            'token'=>$token,
        ],200);

    }


    public function logout(Request $request){
        # hapus
        $request->user()->tokens()->delete();

        # response
        return response()->noContent();
    }

    public function register(RegisterRequest $request){
        $user=User::create([
            'username'=>$request->username,
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        $token=$user->createToken('token')->plainTextToken;

        return new LoginResource([
            'message'=>'success login',
            'user'=>$user,
            'token'=>$token,
        ],200);
    }
}
