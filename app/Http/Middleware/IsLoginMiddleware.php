<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLoginMiddleware
{
    /**
     * Handle an incoming request.
     * Checking user logged in or not using session
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(session()->has("uid")){
        return $next($request);
        }
        return redirect(route("login"))->with("error","Please Login first!");
    }
}
