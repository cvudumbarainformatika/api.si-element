<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=> 'required|string',
            'password'=> 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return response(['message'=> 'data kredensial tidak valid.!'], 500);
        }

        $user = $request->user();

        $token = $user->createToken('personal-sielement-token')->accessToken;
        return new JsonResponse([
            'success' => true,
            'token' => $token,
            'user' => $request->user(),
        ]);

    }

    public function me()
    {
        $me = auth()->user();
        return new JsonResponse(['result' => $me]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return new JsonResponse([
            'success' => true,
            'message' => 'User has been logged out'
        ]);
    }
}
