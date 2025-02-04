<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)){
            $user = Auth::user();
            $user['token'] = $user->createToken('MyApp')->plainTextToken;
            return Helper::ApiResponse('login success', $user);
        }
        return Helper::ApiResponse('email or password does not match.', [], 404);
    }
}
