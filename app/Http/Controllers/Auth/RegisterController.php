<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        $insertData = $request->only('name','email','password');
        $insertData['password'] = bcrypt( $insertData['password'] );

        $created = User::create($insertData);

        return response()->json([
            'message'   =>  'user registered now can login'
        ]);
    }



}
