<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth()->user()->role == 1 ||  Auth()->user()->role == 2) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You do not have permission to access this page!');
    }
}
