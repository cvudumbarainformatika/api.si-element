<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validated->fails()) {
            return new JsonResponse(['status' => 'error', 'message' => 'invalid Credential'], 422);
        }
        // config()->set('jwt.ttl', 60);
        // overide token ttl
        // $token = JWTAuth::setTTL(120)->attempt($validated->validate());
        // $token = auth()->setTTL(120)->attempt($validated->validate());
        $token = JWTAuth::attempt($validated->validate());
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 422);
        }

        $user = JWTAuth::user();
        $user->load('surveyor');
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return new JsonResponse([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function userProfile()
    {

        $user = JWTAuth::user();
        $user->load('surveyor');
        $response = [
            'message' => 'Detail data',
            'data' => $user
        ];
        return response()->json($response);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
