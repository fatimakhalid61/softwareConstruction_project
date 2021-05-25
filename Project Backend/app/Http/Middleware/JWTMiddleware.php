<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['message' => 'Token is Invalid','code' =>401],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['message' => 'Token is Expired','code' =>440],440);
            }else{
                return response()->json(['message' => 'Authorization Token not found','code' =>401],401);
            }
        }
        return $next($request);
    }
}
