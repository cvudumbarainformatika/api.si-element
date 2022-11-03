<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use JWTAuth;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

// use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid', 'message' => 'Unauthenticated.'], 401);
                // } else if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException) {
                // return response()->json(['status' => 'Token is Blaclisted', 'message' => 'Unauthenticated.'], $e->getStatusCode());
            } else if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException) {
                // $respon = $next($request);
                // config()->set('jwt.ttl', 60);
                // $oldToket = JWTAuth::parseToken();
                $newToken = JWTAuth::parseToken()->refresh();
                // $newToken2 = JWTAuth::getToken();
                return response()->json([
                    'status' => 'Token is Expired',
                    'message' => ' get new Token',
                    'token' => $newToken,
                    // 'token2' => $newToken2,
                    // 'data' => response($respon)
                ], 402);
                // $apem = response()->json([
                //     'status' => 'Token is Expired',
                //     'message' => ' get new Token',
                //     'token' => $newToken,
                //     // 'data' => $respon
                // ], 402);
                // return $next($request, $apem);
            } else {
                return response()->json(['status' => 'Authorization Token not found', 'message' => 'Unauthenticated.'], 401);
            }
        }
        return $next($request);
    }
}
