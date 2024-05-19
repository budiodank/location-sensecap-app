<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenMiddleware
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
        $uri = $request->route()->uri;


        if (session()->missing('auth_session')) {
            if (str_contains($uri, 'api')) {
                if (str_contains($request->route()->parameters['any'], 'login')) {
                    return $next($request);
                } else {
                    return response()->json([
                        'code' => 401,
                        'status' => false,
                        'message' => "Token not found",
                    ], 401);
                }
            }
            return redirect('/login');
        }
        return $next($request);
    }
}
