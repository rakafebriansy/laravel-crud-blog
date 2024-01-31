<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //authorization cara2 : membuat middleware
        if (auth()->guest() || !auth()->check() || !auth()->user()->is_admin) {
            abort(403); //membatalkan redirect dan mengirimkan pesan 403 (forbidden)
        }
        return $next($request);
    }
}
