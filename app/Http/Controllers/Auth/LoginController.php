<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $loginData = $request->only('email','password');

        if (Auth::attempt($loginData)){
            $user = User::where('email','=',$loginData['email'])->firstOrFail();

            return response()->json([
                'token' => $user->createToken(env('APP_NAME'))->plainTextToken
            ]);
        }

        return response( ['message' =>  "username or password doesn't match"], 422);
    }
}
