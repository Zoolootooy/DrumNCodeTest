<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\LoginResource;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = $request->user();
            $token = auth()->user()->createToken('API Token')->accessToken;
            $user->token = $token;
            return new LoginResource($user);
        }

        return new ApiErrorResponse('Incorrect email or password');
    }
}
